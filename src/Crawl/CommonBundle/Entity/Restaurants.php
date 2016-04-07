<?php

namespace Crawl\CommonBundle\Entity;

/**
 * Restaurants
 */
class Restaurants
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
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $address;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $RestaurantFoods;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->RestaurantFoods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Restaurants
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return Restaurants
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
     * @return Restaurants
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
     * @return Restaurants
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
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Restaurants
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Restaurants
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Restaurants
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Restaurants
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
     * Add restaurantFood
     *
     * @param \Crawl\CommonBundle\Entity\RestaurantFoods $restaurantFood
     *
     * @return Restaurants
     */
    public function addRestaurantFood(\Crawl\CommonBundle\Entity\RestaurantFoods $restaurantFood)
    {
        $this->RestaurantFoods[] = $restaurantFood;

        return $this;
    }

    /**
     * Remove restaurantFood
     *
     * @param \Crawl\CommonBundle\Entity\RestaurantFoods $restaurantFood
     */
    public function removeRestaurantFood(\Crawl\CommonBundle\Entity\RestaurantFoods $restaurantFood)
    {
        $this->RestaurantFoods->removeElement($restaurantFood);
    }

    /**
     * Get restaurantFoods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurantFoods()
    {
        return $this->RestaurantFoods;
    }
}

