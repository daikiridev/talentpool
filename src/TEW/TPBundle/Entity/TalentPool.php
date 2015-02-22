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
     * @var date
     * 
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdAt;
  
    /**
     * @var creator
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="creator_id", nullable=false)
     */
    private $creator;
    
    /**
     * Constructor
     */
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->profiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
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
        // return $this->getName().' (created by '.$this->getCreator()->getUsername().')';
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
     * @param \Application\Sonata\UserBundle\Entity\User $creator
     * @return TalentPool
     */
    public function setCreator(\Application\Sonata\UserBundle\Entity\User $creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
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
}
