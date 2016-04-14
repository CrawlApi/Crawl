<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/14
 * Time: PM1:01
 */

namespace Crawl\CommonBundle\Service;

use Crawl\CommonBundle\Entity\DoubleColorBalls;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DoubleColorBallService
 * @package Crawl\CommonBundle\Service
 */
class DoubleColorBallService
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
     * @param array $data
     * @throws \Exception
     */
    public function saveNum($data)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $con = $em->getConnection();
        try {
            $em->getConnection()->beginTransaction();
            $con->insert('crawl_double_color_ball', array(
                'redOneNum' => $data[0],
                'redTwoNum' => $data[1],
                'redThreeNum' => $data[2],
                'redFourNum' => $data[3],
                'redFiveNum' => $data[4],
                'redSixNum' => $data[5],
                'blueNum' => $data[6],
                'issue' => $data['issue'],
                'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
            ));
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw new \Exception($e->getMessage());
        }
    }
}