<?php

namespace Vivait\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer")
 *
 */
class Customer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="reference", type="string", length=50)
     */
    private $reference;

    /**
     * @var Name
     * @ORM\Embedded(class="Name", columnPrefix=false)
     */
    private $name;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $bornOn;

    /**
     * @var \DateTime
     * @ORM\Column(name="doj", type="date", nullable=true)
     */
    private $joinedOn;

    /**
     * @var \DateTime
     * @ORM\Column(name="dol", type="date", nullable=true)
     */
    private $leftOn;

    /**
     * @var Gender
     * @ORM\Embedded(class="Gender", columnPrefix=false)
     */
    private $gender;

    /**
     * @var Email
     * @ORM\Embedded(class="Email", columnPrefix=false)
     */
    private $email;

    function __construct($reference)
    {
        $this->joinedOn = new \DateTime();
        $this->reference = $reference;
    }

    /**
     * Gets id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets number
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Gets name
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets bornOn
     * @return \DateTime
     */
    public function getBornOn()
    {
        return $this->bornOn;
    }

    /**
     * Gets joinedOn
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->joinedOn;
    }

    /**
     * Gets leftOn
     * @return \DateTime
     */
    public function getRemovedAt()
    {
        return $this->leftOn;
    }

    /**
     * Gets gender
     * @return Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * A customer leaving the CRM
     * @param \DateTime|null $on
     */
    public function leave(\DateTime $on = null)
    {
        $this->leftOn = $on ?: new \DateTime();
    }

    /**
     * Sets number
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Sets name
     * @param Name $name
     * @return $this
     */
    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets bornOn
     * @param \DateTime $bornOn
     * @return $this
     */
    public function setBornOn(\DateTime $bornOn)
    {
        $this->bornOn = $bornOn;

        return $this;
    }

    /**
     * Sets gender
     * @param Gender|string $gender
     * @return $this
     */
    public function setGender($gender)
    {
        if ($gender !== null && !($gender instanceOf Gender)) {
            $gender = new Gender($gender);
        }

        $this->gender = $gender;

        return $this;
    }

    /**
     * Gets email
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email
     * @param Email|string $email
     * @return $this
     */
    public function setEmail($email)
    {
        if ($email !== null && !($email instanceOf Email)) {
            $email = new Email($email);
        }

        $this->email = $email;

        return $this;
    }
}
