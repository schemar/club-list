<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\MemberStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const SEX_MALE = 'male';
    const SEX_FEMALE = 'female';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @var MemberStatus[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\MemberStatus")
     * @ORM\OrderBy({"priority" = "DESC"})
     */
    private $memberStatuses;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="app.registration.invalidInvitation", groups={"Registration"})
     */
    protected $invitation;

    public function __construct()
    {
        parent::__construct();

        $this->memberStatuses = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email ?: 'New user';
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->setUsername($email);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return $this->gender === self::SEX_FEMALE;
    }

    /**
     * @return MemberStatus[]
     */
    public function getMemberStatuses()
    {
        return $this->memberStatuses;
    }

    /**
     * @param ArrayCollection $memberStatuses
     */
    public function setMemberStatuses(ArrayCollection $memberStatuses)
    {
        $this->memberStatuses = $memberStatuses;
    }

    /**
     * @param MemberStatus $memberStatus
     */
    public function addMemberStatus(MemberStatus $memberStatus)
    {
        $this->memberStatuses->add($memberStatus);
    }

    /**
     * @param MemberStatus $memberStatus
     */
    public function removeMemberStatus(MemberStatus $memberStatus)
    {
        $this->memberStatuses->removeElement($memberStatus);
    }

    /**
     * @return Invitation
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * @param Invitation $invitation
     */
    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }
}