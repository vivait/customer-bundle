<?php

namespace Vivait\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Gender implements ValueObject
{
    const GENDER_OTHER  = 0;
    const GENDER_FEMALE = 1;
    const GENDER_MALE   = 2;

    public static $map = [
        self::GENDER_FEMALE => 'Female',
        self::GENDER_MALE => 'Male',
        self::GENDER_OTHER => 'Other'
    ];

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @param string $gender
     */
    function __construct($gender)
    {
        $gender = (int) $gender;

        if (!isset(self::$map[$gender])) {
            throw new \OutofBoundsException(sprintf('Invalid gender "%s"', $gender));
        }

        $this->gender = $gender;
    }

    /**
     * Gets gender
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return self::$map[$this->gender];
    }

    public static function getAllGenders()
    {
        return self::$map;
    }

    /**
     * Converts an value object in to it's scalar representation
     * @return mixed
     */
    public function toScalar()
    {
        return $this->gender;
    }
}