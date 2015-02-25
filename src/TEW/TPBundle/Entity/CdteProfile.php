<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteProfile
 *
 * @ORM\Table(name="tew_cdteprofile")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteProfileRepository")
 */
class CdteProfile
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdteFunction")
     * @ORM\JoinColumn(name="function_id", referencedColumnName="id", nullable=false)
     */
    private $function;

    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdteLevel")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id", nullable=true)
     */
    private $level;    
    
    /**
     * @var talentpool
     * 
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\TalentPool", inversedBy="profiles")
     * @ORM\JoinTable(name="tew_talentpool_profiles")
     */
    private $talentpool;
    
    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
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
     * Set title
     *
     * @param string $title
     * @return CdteProfile
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CdteProfile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set talentpool
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpool
     * @return CdteProfile
     */
    public function setTalentpool(\TEW\TPBundle\Entity\TalentPool $talentpool = null)
    {
        $this->talentpool = $talentpool;

        return $this;
    }

    /**
     * Get talentpool
     *
     * @return \TEW\TPBundle\Entity\TalentPool 
     */
    public function getTalentpool()
    {
        return $this->talentpool;
    }

    /**
     * Set function
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $function
     * @return CdteProfile
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
     * @return CdteProfile
     */
    public function setLevel(\TEW\TPBundle\Entity\CdteLevel $level=null)
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
}
