<?php

namespace Crawl\CommonBundle\Entity;

/**
 * Student
 */
class Student
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $entranceAt;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $school;

    /**
     * @var array
     */
    private $xs;

    /**
     * @var string
     */
    private $courseOneName;

    /**
     * @var string
     */
    private $courseOneNum;

    /**
     * @var string
     */
    private $courseTwoName;

    /**
     * @var string
     */
    private $courseTwoNum;

    /**
     * @var string
     */
    private $gpa;


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
     * Set code
     *
     * @param string $code
     *
     * @return Student
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
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
     * Set entranceAt
     *
     * @param string $entranceAt
     *
     * @return Student
     */
    public function setEntranceAt($entranceAt)
    {
        $this->entranceAt = $entranceAt;

        return $this;
    }

    /**
     * Get entranceAt
     *
     * @return string
     */
    public function getEntranceAt()
    {
        return $this->entranceAt;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Student
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
     * Set school
     *
     * @param string $school
     *
     * @return Student
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set xs
     *
     * @param array $xs
     *
     * @return Student
     */
    public function setXs($xs)
    {
        $this->xs = $xs;

        return $this;
    }

    /**
     * Get xs
     *
     * @return array
     */
    public function getXs()
    {
        return $this->xs;
    }

    /**
     * Set courseOneName
     *
     * @param string $courseOneName
     *
     * @return Student
     */
    public function setCourseOneName($courseOneName)
    {
        $this->courseOneName = $courseOneName;

        return $this;
    }

    /**
     * Get courseOneName
     *
     * @return string
     */
    public function getCourseOneName()
    {
        return $this->courseOneName;
    }

    /**
     * Set courseOneNum
     *
     * @param string $courseOneNum
     *
     * @return Student
     */
    public function setCourseOneNum($courseOneNum)
    {
        $this->courseOneNum = $courseOneNum;

        return $this;
    }

    /**
     * Get courseOneNum
     *
     * @return string
     */
    public function getCourseOneNum()
    {
        return $this->courseOneNum;
    }

    /**
     * Set courseTwoName
     *
     * @param string $courseTwoName
     *
     * @return Student
     */
    public function setCourseTwoName($courseTwoName)
    {
        $this->courseTwoName = $courseTwoName;

        return $this;
    }

    /**
     * Get courseTwoName
     *
     * @return string
     */
    public function getCourseTwoName()
    {
        return $this->courseTwoName;
    }

    /**
     * Set courseTwoNum
     *
     * @param string $courseTwoNum
     *
     * @return Student
     */
    public function setCourseTwoNum($courseTwoNum)
    {
        $this->courseTwoNum = $courseTwoNum;

        return $this;
    }

    /**
     * Get courseTwoNum
     *
     * @return string
     */
    public function getCourseTwoNum()
    {
        return $this->courseTwoNum;
    }

    /**
     * Set gpa
     *
     * @param string $gpa
     *
     * @return Student
     */
    public function setGpa($gpa)
    {
        $this->gpa = $gpa;

        return $this;
    }

    /**
     * Get gpa
     *
     * @return string
     */
    public function getGpa()
    {
        return $this->gpa;
    }
}

