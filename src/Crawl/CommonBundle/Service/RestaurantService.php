<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/4/7
 * Time: PM1:26
 */

namespace Crawl\CommonBundle\Service;

use Crawl\CommonBundle\Entity\RestaurantFoods;
use Crawl\CommonBundle\Entity\Restaurants;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestaurantService
 * @package Crawl\CommonBundle\Service
 */
class RestaurantService
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
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function saveRestaurants($data)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        foreach ($data['restaurants'] as $k => $restaurants) {
            $restaurant = new Restaurants();
            $restaurant->setId($restaurants['id']);
            $restaurant->setName($restaurants['name']);
            $restaurant->setRating($restaurants['rating']);
            $restaurant->setMonthSales($restaurants['month_sales']);
            $restaurant->setLatitude($restaurants['latitude']);
            $restaurant->setLongitude($restaurants['longitude']);
            $restaurant->setAddress($restaurants['address']);
            $em->persist($restaurant);
            $em->flush();
        }
    }

    /**
     * @param $id
     * @param array $data
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function saveRestaurantFoods($id, $data)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $con = $em->getConnection();
        $em->getConnection()->beginTransaction();
        foreach ($data as $k => $foods) {
            $con->insert('crawl_restaurant_foods', array(
                'name' => $foods['name'],
                'rating' => $foods['rating'],
                'monthSales' => $foods['monthSales'],
                'price' => $foods['price'],
                'RestaurantId' => $id,
                'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
            ));
        }
        $em->getConnection()->commit();
    }
}