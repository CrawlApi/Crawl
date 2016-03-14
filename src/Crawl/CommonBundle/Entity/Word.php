<?php

namespace Crawl\CommonBundle\Entity;

/**
 * Word
 */
class Word
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $word;

    /**
     * @var string
     */
    private $speakUK;

    /**
     * @var string
     */
    private $speakUS;

    /**
     * @var integer
     */
    private $rate;

    /**
     * @var string
     */
    private $n;

    /**
     * @var string
     */
    private $vt;

    /**
     * @var string
     */
    private $vi;

    /**
     * @var string
     */
    private $adj;

    /**
     * @var string
     */
    private $adv;

    /**
     * @var array
     */
    private $shapes;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


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
     * Set word
     *
     * @param string $word
     *
     * @return Word
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set speakUK
     *
     * @param string $speakUK
     *
     * @return Word
     */
    public function setSpeakUK($speakUK)
    {
        $this->speakUK = $speakUK;

        return $this;
    }

    /**
     * Get speakUK
     *
     * @return string
     */
    public function getSpeakUK()
    {
        return $this->speakUK;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return Word
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set n
     *
     * @param string $n
     *
     * @return Word
     */
    public function setN($n)
    {
        $this->n = $n;

        return $this;
    }

    /**
     * Get n
     *
     * @return string
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * Set vt
     *
     * @param string $vt
     *
     * @return Word
     */
    public function setVt($vt)
    {
        $this->vt = $vt;

        return $this;
    }

    /**
     * Get vt
     *
     * @return string
     */
    public function getVt()
    {
        return $this->vt;
    }

    /**
     * Set vi
     *
     * @param string $vi
     *
     * @return Word
     */
    public function setVi($vi)
    {
        $this->vi = $vi;

        return $this;
    }

    /**
     * Get vi
     *
     * @return string
     */
    public function getVi()
    {
        return $this->vi;
    }

    /**
     * Set adj
     *
     * @param string $adj
     *
     * @return Word
     */
    public function setAdj($adj)
    {
        $this->adj = $adj;

        return $this;
    }

    /**
     * Get adj
     *
     * @return string
     */
    public function getAdj()
    {
        return $this->adj;
    }

    /**
     * Set adv
     *
     * @param string $adv
     *
     * @return Word
     */
    public function setAdv($adv)
    {
        $this->adv = $adv;

        return $this;
    }

    /**
     * Get adv
     *
     * @return string
     */
    public function getAdv()
    {
        return $this->adv;
    }

    /**
     * Set shapes
     *
     * @param array $shapes
     *
     * @return Word
     */
    public function setShapes($shapes)
    {
        $this->shapes = $shapes;

        return $this;
    }

    /**
     * Get shapes
     *
     * @return array
     */
    public function getShapes()
    {
        return $this->shapes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Word
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Word
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set speakUS
     *
     * @param string $speakUS
     *
     * @return Word
     */
    public function setSpeakUS($speakUS)
    {
        $this->speakUS = $speakUS;

        return $this;
    }

    /**
     * Get speakUS
     *
     * @return string
     */
    public function getSpeakUS()
    {
        return $this->speakUS;
    }
}
