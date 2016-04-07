<?php

namespace Crawl\CommonBundle\Entity;

/**
 * WordCollins
 */
class WordCollins
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $note;

    /**
     * @var array
     */
    private $sentence;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Crawl\CommonBundle\Entity\Word
     */
    private $Word;


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
     * Set category
     *
     * @param string $category
     *
     * @return WordCollins
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return WordCollins
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set sentence
     *
     * @param array $sentence
     *
     * @return WordCollins
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return array
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return WordCollins
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
     * @return WordCollins
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
     * Set word
     *
     * @param \Crawl\CommonBundle\Entity\Word $word
     *
     * @return WordCollins
     */
    public function setWord(\Crawl\CommonBundle\Entity\Word $word = null)
    {
        $this->Word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \Crawl\CommonBundle\Entity\Word
     */
    public function getWord()
    {
        return $this->Word;
    }
}
