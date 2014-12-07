<?php

namespace App\Web\API\Entity\Wikipedia;

class Article
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var string
     */
    private $title;

    public function __construct($content, $id, $summary, $title)
    {
        $this->content = $content;
        $this->id = $id;
        $this->summary = $summary;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
