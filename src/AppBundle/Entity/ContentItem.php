<?php

namespace AppBundle\Entity;

/**
 * ContentItem
 */
class ContentItem
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $publishedDate;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var integer
     */
    protected $visits;

    /**
     * @var float
     */
    protected $bounceRate;

    /**
     * @var string
     */
    protected $avgTimeOnPage;

    /**
     * @var integer
     */
    protected $visitsPoints;

    /**
     * @var float
     */
    protected $bounceRatePoints;

    /**
     * @var string
     */
    protected $avgTimeOnPagePoints;

    /**
     * @var string
     */
    protected $totalPoints;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ContentItem
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ContentItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return ContentItem
     */
    public function setPublishedDate(\DateTime $publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return ContentItem
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set visits
     *
     * @param integer $visits
     *
     * @return ContentItem
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * Get visits
     *
     * @return integer
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Set bounceRate
     *
     * @param float $bounceRate
     *
     * @return ContentItem
     */
    public function setBounceRate($bounceRate)
    {
        $this->bounceRate = $bounceRate;

        return $this;
    }

    /**
     * Get bounceRate
     *
     * @return float
     */
    public function getBounceRate()
    {
        return $this->bounceRate;
    }

    /**
     * Set avgTimeOnPage
     *
     * @param float $avgTimeOnPage
     *
     * @return ContentItem
     */
    public function setAvgTimeOnPage($avgTimeOnPage)
    {
        $this->avgTimeOnPage = $avgTimeOnPage;

        return $this;
    }

    /**
     * Get avgTimeOnPage
     *
     * @return float
     */
    public function getAvgTimeOnPage()
    {
        return $this->avgTimeOnPage;
    }

    /**
     * Set visitsPoints
     *
     * @param integer $visitsPoints
     *
     * @return ContentItem
     */
    public function setVisitsPoints($visitsPoints)
    {
        $this->visitsPoints = $visitsPoints;

        return $this;
    }

    /**
     * Get visitsPoints
     *
     * @return integer
     */
    public function getVisitsPoints()
    {
        return $this->visitsPoints;
    }

    /**
     * Set bounceRatePoints
     *
     * @param integer $bounceRatePoints
     *
     * @return ContentItem
     */
    public function setBounceRatePoints($bounceRatePoints)
    {
        $this->bounceRatePoints = $bounceRatePoints;

        return $this;
    }

    /**
     * Get bounceRatePoints
     *
     * @return integer
     */
    public function getBounceRatePoints()
    {
        return $this->bounceRatePoints;
    }

    /**
     * Set avgTimeOnPagePoints
     *
     * @param integer $avgTimeOnPagePoints
     *
     * @return ContentItem
     */
    public function setAvgTimeOnPagePoints($avgTimeOnPagePoints)
    {
        $this->avgTimeOnPagePoints = $avgTimeOnPagePoints;

        return $this;
    }

    /**
     * Get avgTimeOnPagePoints
     *
     * @return integer
     */
    public function getAvgTimeOnPagePoints()
    {
        return $this->avgTimeOnPagePoints;
    }

    public function getTotalPoints()
    {
        return $this->getVisitsPoints() + $this->getBounceRatePoints() + $this->getAvgTimeOnPagePoints();
    }
}
