<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="member_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemberStatusRepository")
 */
class MemberStatus
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * MemberStatus constructor initializes values.
     */
    public function __construct()
    {
        $this->priority = 0;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->id) {
            return 'New MemberStatus';
        }

        return $this->translate()->getMixedName();
    }

    /**
     * @param string $name
     */
    public function setEnglishName($name) {
        $this->setMaleName('en', $name);
    }

    /**
     * @return string
     */
    public function getEnglishName() {
        return $this->getMaleName('en');
    }

    /**
     * @param string $description
     */
    public function setEnglishDescription($description) {
        $this->setMaleDescription('en', $description);
    }

    /**
     * @return string
     */
    public function getEnglishDescription() {
        return $this->getMaleDescription('en');
    }

    /**
     * @param string $name
     */
    public function setGermanMaleName($name) {
        $this->setMaleName('de', $name);
    }

    /**
     * @return string
     */
    public function getGermanMaleName() {
        return $this->getMaleName('de');
    }

    /**
     * @param string $description
     */
    public function setGermanMaleDescription($description) {
        $this->setMaleDescription('de', $description);
    }

    /**
     * @return string
     */
    public function getGermanMaleDescription() {
        return $this->getMaleDescription('de');
    }

    /**
     * @param string $name
     */
    public function setGermanFemaleName($name) {
        $this->setFemaleName('de', $name);
    }

    /**
     * @return string
     */
    public function getGermanFemaleName() {
        return $this->getFemaleName('de');
    }

    /**
     * @param string $description
     */
    public function setGermanFemaleDescription($description) {
        $this->setFemaleDescription('de', $description);
    }

    /**
     * @return string
     */
    public function getGermanFemaleDescription() {
        return $this->getFemaleDescription('de');
    }

    /**
     * @param string $locale
     * @param string $name
     */
    private function setMaleName($locale, $name)
    {
        $this->translate($locale)->setMaleName($name);
    }

    /**
     * @param string $locale
     * @return string
     */
    private function getMaleName($locale)
    {
        return $this->translate($locale)->getMaleName();
    }

    /**
     * @param string $locale
     * @param string $description
     */
    private function setMaleDescription($locale, $description)
    {
        $this->translate($locale)->setMaleDescription($description);
    }

    /**
     * @param string $locale
     * @return string
     */
    private function getMaleDescription($locale)
    {
        return $this->translate($locale)->getMaleDescription();
    }

    /**
     * @param string $locale
     * @param string $name
     */
    private function setFemaleName($locale, $name)
    {
        $this->translate($locale)->setFemaleName($name);
    }

    /**
     * @param string $locale
     * @return string
     */
    private function getFemaleName($locale)
    {
        return $this->translate($locale)->getFemaleName();
    }

    /**
     * @param string $locale
     * @param string $description
     */
    private function setFemaleDescription($locale, $description)
    {
        $this->translate($locale)->setFemaleDescription($description);
    }

    /**
     * @param string $locale
     * @return string
     */
    private function getFemaleDescription($locale)
    {
        return $this->translate($locale)->getFemaleDescription();
    }
}
