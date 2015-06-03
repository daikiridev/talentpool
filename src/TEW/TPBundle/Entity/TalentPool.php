<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TalentPool
 *
 * @ORM\Table(name="tew_talentpool")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\TalentPoolRepository")
 */
class TalentPool
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var profiles
     * 
     * @ORM\OneToMany(targetEntity="CdteProfile", mappedBy="talentpool", cascade={"all"})
     *
     */
    private $profiles;

    /**
     * @var candidates

     * @ORM\ManyToMany(targetEntity="Candidate", mappedBy="talentpools")
     */
    private $candidates;
    
    /**
     * @var companies

     * @ORM\ManyToMany(targetEntity="Company", mappedBy="talentpools")
     */
    private $companies;
    
    /**
    
    /**
     * @var owningcompany
     *
     * @ORM\ManyToOne(targetEntity="Company", cascade={"persist"})
     * @ORM\JoinColumn(name="owningcompany_id", nullable=true)
     */
    private $owningcompany;
    
    /**
     * @var date
     * 
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdAt;
  
    /**
     * @var creator
     *
     * @ORM\ManyToOne(targetEntity="TEW\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="creator_id", nullable=false)
     */
    private $creator;

    /**
     * @var picture
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $picture;
    
    /**
     * Constructor
     */
    public function __construct(\TEW\UserBundle\Entity\User $user)
    {
        $this->profiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->owningcompany = $user->getCompany();
        $this->createdAt = new \DateTime();
        $this->creator = $user;
    }
    
    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
        // return $this->profiles->count()==1?$this->getName().' > '.$this->profiles[0]:$this->getName();
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
     * @return TalentPool
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
     * Add candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return TalentPool
     */
    public function addCandidate(\TEW\TPBundle\Entity\Candidate $candidate)
    {
        $this->candidates[] = $candidate;

        return $this;
    }

    /**
     * Remove candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     */
    public function removeCandidate(\TEW\TPBundle\Entity\Candidate $candidate)
    {
        $this->candidates->removeElement($candidate);
    }

    /**
     * Get candidates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TalentPool
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
     * Set creator
     *
     * @param \TEW\UserBundle\Entity\User $creator
     * @return TalentPool
     */
    public function setCreator(\TEW\UserBundle\Entity\User $creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \TEW\UserBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
    

    /**
     * Add profiles
     *
     * @param \TEW\TPBundle\Entity\CdteProfile $profiles
     * @return TalentPool
     */
    public function addProfile(\TEW\TPBundle\Entity\CdteProfile $profiles)
    {
        $this->profiles[] = $profiles;

        return $this;
    }

    /**
     * Remove profiles
     *
     * @param \TEW\TPBundle\Entity\CdteProfile $profiles
     */
    public function removeProfile(\TEW\TPBundle\Entity\CdteProfile $profiles)
    {
        $this->profiles->removeElement($profiles);
    }

    /**
     * Get profiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TalentPool
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
     * Set picture
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $picture
     * @return TalentPool
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
     * Add companies
     *
     * @param \TEW\TPBundle\Entity\Company $companies
     * @return TalentPool
     */
    public function addCompany(\TEW\TPBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \TEW\TPBundle\Entity\Company $companies
     */
    public function removeCompany(\TEW\TPBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Set owningcompany
     *
     * @param \TEW\TPBundle\Entity\Company $owningcompany
     * @return TalentPool
     */
    public function setOwningcompany(\TEW\TPBundle\Entity\Company $owningcompany)
    {
        $this->owningcompany = $owningcompany;

        return $this;
    }

    /**
     * Get owningcompany
     *
     * @return \TEW\TPBundle\Entity\Company 
     */
    public function getOwningcompany()
    {
        return $this->owningcompany;
    }
}
