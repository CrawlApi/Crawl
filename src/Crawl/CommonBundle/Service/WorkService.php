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
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class WorkService
 * @package Crawl\CommonBundle\Service
 */
class WorkService
{
    use ContainerAwareTrait;

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
}