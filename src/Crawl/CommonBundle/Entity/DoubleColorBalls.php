<?php

namespace Crawl\CommonBundle\Entity;

/**
 * DoubleColorBalls
 */
class DoubleColorBalls
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $redOneNum;

    /**
     * @var integer
     */
    private $redTwoNum;

    /**
     * @var integer
     */
    private $redThreeNum;

    /**
     * @var integer
     */
    private $redFourNum;

    /**
     * @var integer
     */
    private $redFiveNum;

    /**
     * @var integer
     */
    private $redSixNum;

    /**
     * @var integer
     */
    private $blueNum;

    /**
     * @var integer
     */
    private $issue;

    /**
     * @var \DateTime
     */
    private $createdAt;


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
     * Set redOneNum
     *
     * @param integer $redOneNum
     *
     * @return DoubleColorBalls
     */
    public function setRedOneNum($redOneNum)
    {
        $this->redOneNum = $redOneNum;

        return $this;
    }

    /**
     * Get redOneNum
     *
     * @return integer
     */
    public function getRedOneNum()
    {
        return $this->redOneNum;
    }

    /**
     * Set redTwoNum
     *
     * @param integer $redTwoNum
     *
     * @return DoubleColorBalls
     */
    public function setRedTwoNum($redTwoNum)
    {
        $this->redTwoNum = $redTwoNum;

        return $this;
    }

    /**
     * Get redTwoNum
     *
     * @return integer
     */
    public function getRedTwoNum()
    {
        return $this->redTwoNum;
    }

    /**
     * Set redThreeNum
     *
     * @param integer $redThreeNum
     *
     * @return DoubleColorBalls
     */
    public function setRedThreeNum($redThreeNum)
    {
        $this->redThreeNum = $redThreeNum;

        return $this;
    }

    /**
     * Get redThreeNum
     *
     * @return integer
     */
    public function getRedThreeNum()
    {
        return $this->redThreeNum;
    }

    /**
     * Set redFourNum
     *
     * @param integer $redFourNum
     *
     * @return DoubleColorBalls
     */
    public function setRedFourNum($redFourNum)
    {
        $this->redFourNum = $redFourNum;

        return $this;
    }

    /**
     * Get redFourNum
     *
     * @return integer
     */
    public function getRedFourNum()
    {
        return $this->redFourNum;
    }

    /**
     * Set redFiveNum
     *
     * @param integer $redFiveNum
     *
     * @return DoubleColorBalls
     */
    public function setRedFiveNum($redFiveNum)
    {
        $this->redFiveNum = $redFiveNum;

        return $this;
    }

    /**
     * Get redFiveNum
     *
     * @return integer
     */
    public function getRedFiveNum()
    {
        return $this->redFiveNum;
    }

    /**
     * Set redSixNum
     *
     * @param integer $redSixNum
     *
     * @return DoubleColorBalls
     */
    public function setRedSixNum($redSixNum)
    {
        $this->redSixNum = $redSixNum;

        return $this;
    }

    /**
     * Get redSixNum
     *
     * @return integer
     */
    public function getRedSixNum()
    {
        return $this->redSixNum;
    }

    /**
     * Set blueNum
     *
     * @param integer $blueNum
     *
     * @return DoubleColorBalls
     */
    public function setBlueNum($blueNum)
    {
        $this->blueNum = $blueNum;

        return $this;
    }

    /**
     * Get blueNum
     *
     * @return integer
     */
    public function getBlueNum()
    {
        return $this->blueNum;
    }

    /**
     * Set issue
     *
     * @param integer $issue
     *
     * @return DoubleColorBalls
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;

        return $this;
    }

    /**
     * Get issue
     *
     * @return integer
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return DoubleColorBalls
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
}

