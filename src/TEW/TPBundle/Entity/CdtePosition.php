<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CdtePosition
 *
 * @ORM\Table(name="tew_cdteposition")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdtePositionRepository")
 * @UniqueEntity(fields={"function", "level"})
 */
class CdtePosition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var function
     * 
     * @ORM\ManyToOne(targetEntity="CdteFunction", cascade={"persist"})
     * @ORM\JoinColumn(name="function_id", nullable=false)
     */
    private $function;

    /**
     * @var level
     * 
     * @ORM\ManyToOne(targetEntity="CdteLevel", cascade={"persist"})
     * @ORM\JoinColumn(name="level_id", nullable=false)
     */
    private $level;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var talentpools
     * 
     * @ORM\ManyToMany(targetEntity="TEW\TPBundle\Entity\TalentPool", mappedBy="positions")
     */
    private $talentpools;

    /**
     * Set name
     *
     * @param string $name
     * @return CdtePosition
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set function
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $function
     * @return CdtePosition
     */
    public function setFunction(\TEW\TPBundle\Entity\CdteFunction $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return \TEW\TPBundle\Entity\CdteFunction 
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set level
     *
     * @param \TEW\TPBundle\Entity\CdteLevel $level
     * @return CdtePosition
     */
    public function setLevel(\TEW\TPBundle\Entity\CdteLevel $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \TEW\TPBundle\Entity\CdteLevel 
     */
    public function getLevel()
    {
        return $this->level;
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
    
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add talentpools
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpools
     * @return CdtePosition
     */
    public function addTalentpool(\TEW\TPBundle\Entity\TalentPool $talentpools)
    {
        $this->talentpools[] = $talentpools;

        return $this;
    }

    /**
     * Remove talentpools
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpools
     */
    public function removeTalentpool(\TEW\TPBundle\Entity\TalentPool $talentpools)
    {
        $this->talentpools->removeElement($talentpools);
    }

    /**
     * Get talentpools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTalentpools()
    {
        return $this->talentpools;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->talentpools = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString for talentpools
     */
    public static function stringOfTalentPools(\Doctrine\Common\Collections\ArrayCollection $tps)
    {
        return implode(' / ', $tps->map(TalentPool::__toString())->toArray());
    }
}
