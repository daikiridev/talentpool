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
     * @var positions
     * 
     * @ORM\ManyToMany(targetEntity="CdtePosition", inversedBy="talentpools", cascade={"persist"})
     * @ORM\JoinTable(name="tew_talentpool_positions")
     */
    private $positions;

    /**
     * @var candidates
     * 
     * @ORM\ManyToMany(targetEntity="Candidate", inversedBy="talentpools")
     * @ORM\JoinTable(name="tew_talentpool_candidates")
     */
    private $candidates;

    /**
     * @var date
     * 
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
  
    /**
     * @var creator
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="creator_id", nullable=false)
     */
    private $creator;
    

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
     * Add positions
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $positions
     * @return TalentPool
     */
    public function addPosition(\TEW\TPBundle\Entity\CdtePosition $positions)
    {
        $this->positions[] = $positions;

        return $this;
    }

    /**
     * Remove positions
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $positions
     */
    public function removePosition(\TEW\TPBundle\Entity\CdtePosition $positions)
    {
        $this->positions->removeElement($positions);
    }

    /**
     * Get positions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPositions()
    {
        return $this->positions;
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return TalentPool
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * Constructor
     */
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->positions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->candidates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creationDate = new \DateTime();
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
}
