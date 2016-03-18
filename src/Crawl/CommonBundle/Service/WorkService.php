<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/9
 * Time: 下午2:39
 */

namespace Crawl\CommonBundle\Service;

use Crawl\CommonBundle\Entity\Word;
use Crawl\CommonBundle\Entity\WordCollins;
use Crawl\CommonBundle\Helper\MongoDBHelper;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class WorkService
 * @package Crawl\CommonBundle\Service
 */
class WorkService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param $data
     */
    public function save($data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        //先存word
        $word = $this->saveWord($data);
        //存wordCollins
        if ($word && $accessor->getValue($data, '[collins]')) {
            $this->saveWordCollins($word, $data['collins']);
        }
    }

    /**
     * @param $data
     * @return Word|null
     */
    public function saveWord($data)
    {
        $em = $this->entityManager();
        $word = $em->getRepository('CrawlCommonBundle:Word')->findOneBy(array('word' => $data['word']));
        if ($word)
            return null;
        $accessor = PropertyAccess::createPropertyAccessor();
        $word = new Word();
        //word
        $word->setWord($data['word']);
        //rate
        $word->setRate($data['rate']);
        //speakUK
        $word->setSpeakUK($data['speak'][0]);
        $word->setSpeakUS($data['speak'][1]);
        //translation
        if ($accessor->getValue($data, '[translation]')) {
            foreach ($accessor->getValue($data, '[translation]') as $k => $v) {
                switch ($v[0]) {
                    case 'n':
                        $word->setN($v[1]);
                        break;
                    case 'adj':
                        $word->setAdj($v[1]);
                        break;
                    case 'adv':
                        $word->setAdv($v[1]);
                        break;
                    case 'vi':
                        $word->setVi($v[1]);
                        break;
                    case 'vt':
                        $word->setVt($v[1]);
                        break;
                    default:
                        break;
                }
            }
        }
        //shapes
        $word->setShapes($accessor->getValue($data, '[shapes]'));
        $em->persist($word);
        $em->flush();

        return $word;
    }

    /**
     * @param $word
     * @param $collins
     */
    public function saveWordCollins($word, $collins)
    {
        $em = $this->entityManager();
        $accessor = PropertyAccess::createPropertyAccessor();

        $em->getConnection()->beginTransaction();
        foreach ($collins as $k => $v) {
            foreach ($v['translation'] as $sentence) {
                if (is_array($sentence)) {
                    $wordCollins = new WordCollins();
                    $wordCollins->setNote($accessor->getValue($sentence, '[note]'));
                    $wordCollins->setSentence($accessor->getValue($sentence, '[sentence]'));
                    if ($accessor->getValue($v['translation'], '[zh]') && $accessor->getValue($v['translation'], '[en]')) {
                        $wordCollins->setCategory($v['translation']['zh'] . ' ' . $v['translation']['en']);
                    }
                    $wordCollins->setWord($word);
                    $em->persist($wordCollins);
                    $em->flush();
                }
            }
        }
        $em->getConnection()->commit();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function entityManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * @param $data
     */
    public function saveToMongoDB($data)
    {
        $mongodb = new MongoDBHelper('Crawl');
        $accessor = PropertyAccess::createPropertyAccessor();
        $word = $this->saveWordToMongoDB($data, $mongodb);

        if ($word && $accessor->getValue($data, '[collins]')) {
            $collinsInDB = $this->saveWordCollinsToMongoDB($data['collins'], $mongodb);
            //DBRef
            $result = $mongodb->findOne('crawl_word', $word);
            $dbRef = array();
            foreach ($collinsInDB as $v) {
                if ($newDBRef = $mongodb->findOne('crawl_word_collins', $v))
                    array_push($dbRef, $newDBRef->_id);
            }
            $mongodb->update('crawl_word', $result, ['$set' => ['collins' => $dbRef]], array());
        }

    }

    /**
     * @param $data
     * @param \Crawl\CommonBundle\Helper\MongoDBHelper $mongodb
     * @return null
     */
    public function saveWordToMongoDB($data, $mongodb)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $word = $mongodb->findOne('crawl_word', array('word' => $data['word']));

        if ($word)
            return false;

        $word = array(
            'word' => $data['word'],
            'speakUK' => $data['speak'][0],
            'speakUS' => $data['speak'][1],
            'rate' => $data['rate'],
            'n' => null,
            'adj' => null,
            'adv' => null,
            'vi' => null,
            'vt' => null,
            'shapes' => $accessor->getValue($data, '[shapes]'),
            'collins' => null
        );
        if ($accessor->getValue($data, '[translation]')) {
            foreach ($accessor->getValue($data, '[translation]') as $k => $v) {
                $word[$v[0]] = $v[1];
            }
        }
        if ($mongodb->insert('crawl_word', $word))
            return $word;
        return false;
    }

    /**
     * @param $collins
     * @param \Crawl\CommonBundle\Helper\MongoDBHelper $mongodb
     * @return array
     */
    public function saveWordCollinsToMongoDB($collins, $mongodb)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $collinsInDB = array();

        foreach ($collins as $k => $v) {
            foreach ($v['translation'] as $sentence) {
                if (is_array($sentence)) {
                    $wordCollins = array(
                        'category' => null,
                        'note' => $accessor->getValue($sentence, '[note]'),
                        'sentence' => $accessor->getValue($sentence, '[sentence]')
                    );
                    if ($accessor->getValue($v['translation'], '[zh]') && $accessor->getValue($v['translation'], '[en]')) {
                        $wordCollins['category'] = ($v['translation']['zh'] . ' ' . $v['translation']['en']);
                    }
                    if (!$mongodb->findOne('crawl_word_collins', $wordCollins))
                        if ($mongodb->insert('crawl_word_collins', $wordCollins))
                            array_push($collinsInDB, $wordCollins);
                }
            }
        }

        return $collinsInDB;
    }
}