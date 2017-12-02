<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="member_status_translation")
 * @ORM\Entity
 */
class MemberStatusTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(name="male_name", type="string", length=255)
     */
    protected $maleName;

    /**
     * @ORM\Column(name="male_description", type="string", length=255)
     */
    protected $maleDescription;

    /**
     * @ORM\Column(name="female_name", type="string", length=255, nullable=true)
     */
    protected $femaleName;

    /**
     * @ORM\Column(name="female_description", type="string", length=255, nullable=true)
     */
    protected $femaleDescription;

    /**
     * @return string
     */
    public function getMaleName()
    {
        return $this->maleName;
    }

    /**
     * @param  string
     * @return null
     */
    public function setMaleName($name)
    {
        $this->maleName = $name;

        return null;
    }

    /**
     * @return string
     */
    public function getMaleDescription()
    {
        return $this->maleDescription;
    }

    /**
     * @param  string
     * @return null
     */
    public function setMaleDescription($description)
    {
        $this->maleDescription = $description;

        return null;
    }

    /**
     * @return string
     */
    public function getFemaleName()
    {
        if ($this->femaleName) {
            return $this->femaleName;
        }

        return $this->maleName;
    }

    /**
     * @param  string
     * @return null
     */
    public function setFemaleName($name)
    {
        $this->femaleName = $name;

        return null;
    }

    /**
     * @return string
     */
    public function getFemaleDescription()
    {
        if ($this->femaleDescription) {
            return $this->femaleDescription;
        }

        return $this->maleDescription;
    }

    /**
     * @param  string
     * @return null
     */
    public function setFemaleDescription($description)
    {
        $this->femaleDescription = $description;

        return null;
    }
}
