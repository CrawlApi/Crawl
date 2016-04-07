<?php

namespace Crawl\CommonBundle\Entity;

/**
 * RestaurantFoods
 */
class RestaurantFoods
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $rating;

    /**
     * @var integer
     */
    private $monthSales;

    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Crawl\CommonBundle\Entity\Restaurants
     */
    private $Restaurant;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RestaurantFoods
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return RestaurantFoods
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set monthSales
     *
     * @param integer $monthSales
     *
     * @return RestaurantFoods
     */
    public function setMonthSales($monthSales)
    {
        $this->monthSales = $monthSales;

        return $this;
    }

    /**
     * Get monthSales
     *
     * @return integer
     */
    public function getMonthSales()
    {
        return $this->monthSales;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return RestaurantFoods
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return RestaurantFoods
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set restaurant
     *
     * @param \Crawl\CommonBundle\Entity\Restaurants $restaurant
     *
     * @return RestaurantFoods
     */
    public function setRestaurant(\Crawl\CommonBundle\Entity\Restaurants $restaurant = null)
    {
        $this->Restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Crawl\CommonBundle\Entity\Restaurants
     */
    public function getRestaurant()
    {
        return $this->Restaurant;
    }
}

