<?php

namespace Vivait\CustomerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Name {
    public $stringFormat = '%1$s. %2$s %3$s %4$s';
    public $shortStringFormat = '%2$s %4$s';

    /**
     * @var string
     * @ORM\Embedded(class="Title", columnPrefix=false)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="forename", type="string", length=50, nullable=true)
     */
    private $forename;

    /**
     * @var string
     * @ORM\Column(name="middlename", type="string", length=50, nullable=true)
     */
    private $middlename;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="surname", type="string", length=50, nullable=true)
     */
    private $surname;

    function __construct($title, $forename, $middlename, $surname)
    {
        $this->title = $title;
        $this->forename = $forename;
        $this->middlename = $middlename;
        $this->surname = $surname;
    }

    public function __toString() {
        return sprintf($this->stringFormat, $this->title, $this->forename, $this->middlename, $this->surname);
    }

    public function toShortFormat() {
        return sprintf($this->shortStringFormat, $this->title, $this->forename, $this->middlename, $this->surname);
    }

    /**
     * Gets title
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets forename
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Gets middlename
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Gets surname
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }
}