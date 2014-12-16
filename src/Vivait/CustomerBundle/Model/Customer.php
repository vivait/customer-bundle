<?php

namespace Vivait\CustomerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Vivait\StringGeneratorBundle\Annotation\GeneratorAnnotation as Generate;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="customer")
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
     * @Generate(generator="string", override=false, options={"length"=4, "chars"="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"})
     * @ORM\Column(name="reference", type="string", length=50)
     */
    private $reference;

    /**
     * @var Name
     */
    private $name;

    /* Temporary inline mappings of Name embeddable */

    /**
     * @var Title
     * @ORM\Column(name="title", type="title", length=5, nullable=true)
     */
    private $title;

    /**
     * @var string
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
     * @ORM\Column(name="surname", type="string", length=50, nullable=true)
     */
    private $surname;

    /* End temporary */

    /**
     * @var \DateTime
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
     * @var \DateTime
     * @ORM\Column(name="updatedAt", type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Gender
     * @ORM\Column(name="gender", type="gender", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var Email
     * @ORM\Column(name="email", type="email", nullable=true)
     */
    private $email;

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
     * Gets email
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
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
     * Registers/joins a customer
     *
     * @param Email $email The customer's email address
     * @param Name $name The customer's name(s)
     * @param \DateTime $bornOn The customer's date of birth
     * @param Gender $gender The customer's gender
     * @param string $reference The customer's unique reference (auto-generated if null)
     * @return Customer
     */
    public static function register(Email $email, Name $name, \DateTime $bornOn = null, Gender $gender = null, $reference = null)
    {
        $customer = new static();
        $customer->reference = $reference;
        $customer->email = $email;
        $customer->name = $name;
        $customer->bornOn = $bornOn;
        $customer->gender = $gender;

        $customer->joinedOn = new \DateTime();

        return $customer;
    }

    /**
     * Updates a customer
     *
     * @param Email $email The customer's email address
     * @param Name $name The customer's name(s)
     * @param \DateTime $bornOn The customer's date of birth
     * @param Gender $gender The customer's gender
     */
    function update(Email $email, Name $name, \DateTime $bornOn, Gender $gender)
    {
        $this->email = $email;
        $this->name = $name;
        $this->bornOn = $bornOn;
        $this->gender = $gender;

        $this->updatedAt = new \DateTime();
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateInternalNameColumns()
    {
        if ($this->name) {
            $this->forename = $this->name->getForename();
            $this->middlename = $this->name->getMiddlename();
            $this->surname = $this->name->getSurname();
            $this->title = $this->name->getTitle();
        }
    }

    /**
     * @ORM\PostLoad
     */
    public function loadInternalNameColumns()
    {
        $this->name = new Name($this->forename, $this->surname, $this->middlename, $this->title);
    }
}
