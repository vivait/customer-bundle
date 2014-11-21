<?php

namespace Vivait\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable()
 */
class Title
{
    const TITLE_MR   = 'mr';
    const TITLE_MRS  = 'mrs';
    const TITLE_MISS = 'miss';
    const TITLE_MS   = 'ms';

    public static $map = [
        self::TITLE_MR => 'Mr',
        self::TITLE_MRS => 'Mrs',
        self::TITLE_MISS => 'Miss',
        self::TITLE_MS => 'Ms'
    ];

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=5, nullable=true)
     */
    private $title;

    function __construct($title)
    {
        if (!isset(self::$map[$title])) {
            throw new \OutofBoundsException(sprintf('Invalid title "%s"', $title));
        }

        $this->title = $title;
    }

    /**
     * Gets title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    function __toString()
    {
        return self::$map[$this->title];
    }

    public static function getAllTitles()
    {
        return self::$map;
    }
}