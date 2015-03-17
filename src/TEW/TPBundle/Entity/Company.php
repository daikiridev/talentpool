<?php

namespace TEW\TPBundle\Entity;

//# Tag management
//use Fogs\TaggingBundle\Interfaces\Taggable;
//use Fogs\TaggingBundle\Traits\TaggableTrait;

use Application\Sonata\MediaBundle\Entity\Media;

// ORM mapping
//use DoctrineExtensions\Taggable\Taggable;
//use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 * 
 * @ORM\Table(name="tew_company")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CompanyRepository")
 */
class Company // implements Taggable
{
    // const TAGGABLE_TYPE = 'candidate';
    
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
     * @ORM\Column(name="name", type="string", length=127)
     */
    private $name;

    
    /**
     * @var picture
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $picture;
    
    
    /**
     * @var bool $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    /**
     * @var talentpools
     * 
     * @ORM\ManyToMany(targetEntity="TalentPool", inversedBy="companies")
     * @ORM\JoinTable(name="tew_talentpool_companies")
     * 
     */
    private $talentpools;
 
    /**
     * @var users
     *
     * @ORM\OneToMany(targetEntity="TEW\UserBundle\Entity\User", mappedBy="company") // , cascade={"persist", "remove"}   
     * 
     */
    private $users;

    /**
     * @var date
     * 
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdAt;

    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->active = true;
        $this->talentpools = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
    }
    
    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set active
     *
     * @param boolean $active
     * @return Company
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Company
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set picture
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $picture
     * @return Company
     */
    public function setPicture(\Application\Sonata\MediaBundle\Entity\Media $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Add talentpools
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpools
     * @return Company
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
     * Add users
     *
     * @param \TEW\TPBundle\Entity\User $users
     * @return Company
     */
    public function addUser(\TEW\TPBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \TEW\TPBundle\Entity\User $users
     */
    public function removeUser(\TEW\TPBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
