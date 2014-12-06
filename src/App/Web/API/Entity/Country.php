<?php

namespace App\Web\API\Entity;

class Country
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $score;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $name;

    public function __construct($id, $score, $href, $name)
    {
        $this->id = $id;
        $this->score = $score;
        $this->href = $href;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
