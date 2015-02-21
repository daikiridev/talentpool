<?php

namespace TEW\TPBundle\Entity;

//# Tag management
//use Fogs\TaggingBundle\Interfaces\Taggable;
//use Fogs\TaggingBundle\Traits\TaggableTrait;

use Application\Sonata\MediaBundle\Entity\Media;

// ORM mapping
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 * 
 * @ORM\Table(name="tew_candidate")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CandidateRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class Candidate implements Taggable
{
    const TAGGABLE_TYPE = 'candidate';
    
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
     * @ORM\Column(name="gender", type="string", length=3)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=127)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="middlename", type="string", length=127, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=127)
     */
    private $lastName;
    
    /**
     * @var date
     * 
     * @ORM\Column(name="dateofbirth", type="date")
     */
    private $dateOfBirth;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=127)
     * @Assert\Email()
     */
    
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone1", type="string", length=31)
     */
    private $phone1;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=31, nullable=true)
     */
    private $phone2;
    
    /**
     * @var addresses
     *
     * @ORM\OneToMany(targetEntity="Address", mappedBy="candidate", cascade={"persist", "remove"})   
     * 
     */
    private $addresses;
    
    /**
     * @var picture
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $picture;
    
    /**
     * @var resume
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $resume;
    
    /**
     * @var position
     *
     * @ORM\ManyToOne(targetEntity="CdtePosition")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     *  })
     */
    private $position;
    
    /**
     * level: years of experience
     * @var level
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;
    
    /**
     * @var annualIncome (USD)
     *
     * @ORM\Column(name="annualincome", type="integer")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Annual income must be positive"
     * )
     */
    private $annualIncome;
    
    /**
     * @var targetPosition1
     *
     * @ORM\ManyToOne(targetEntity="CdtePosition")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="targetposition1_id", referencedColumnName="id")
     *  })
     */
    private $targetPosition1;
    
    /**
     * @var targetPosition2
     *
     * @ORM\ManyToOne(targetEntity="CdtePosition")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="targetposition2_id", referencedColumnName="id", nullable=true)
     *  })
     */
    private $targetPosition2;
    
    /**
     * @var targetPosition3
     *
     * @ORM\ManyToOne(targetEntity="CdtePosition")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="targetposition3_id", referencedColumnName="id", nullable=true)
     *  })
     */
    private $targetPosition3; 
    
//    /**
//     * @var targetPositions
//     * 
//     * @ORM\ManyToMany(targetEntity="CdtePosition")
//     * @ORM\JoinTable(name="tew_cdte_targetpositions",
//     *  joinColumns={@ORM\JoinColumn(name="position_id", referencedColumnName="id")},
//     *  inverseJoinColumns={@ORM\JoinColumn(name="candidate_id", referencedColumnName="id")}
//     *  )
//     */
//    private $targetPositions;

    /**
     * @var mobilities
     *
     * @ORM\OneToMany(targetEntity="CdteMobility", mappedBy="candidate", cascade={"persist", "remove"})   
     * 
     */
    private $mobilities;
    
    /**
     * @var languagesSkills
     * 
     * @ORM\ManyToMany(targetEntity="CdteLanguage")
     * @ORM\JoinTable(name="tew_cdte_languageskills",
     *  joinColumns={@ORM\JoinColumn(name="languageskill_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="candidate_id", referencedColumnName="id")}
     *  )
     */
    private $languagesSkills; 
    
    /**
     * @var talentpools
     * 
     * @ORM\ManyToMany(targetEntity="TalentPool", inversedBy="candidates")
     * @ORM\JoinTable(name="tew_talentpool_candidates")
     * 
     */
    private $talentpools;
    
    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=127)
     */
    private $origin;
    
    /**
     * @var comments
     *
     * @ORM\OneToMany(targetEntity="CdteComment", mappedBy="candidate", cascade={"persist", "remove"})   
     * 
     */
    private $comments;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     */
    private $tags;

    /**
     * @var date
     * 
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdAt;
  
    /**
     * @var creator
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", nullable=false)
     */
    private $creator;
    

    /**
     * Constructor
     */
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user=null)
    {
        $this->mobilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languagesSkills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->talentpools = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->getLastName().' '.$this->getFirstName().' '.$this->getMiddleName().' ('.$this->getGender().')';
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
     * Set gender
     *
     * @param string $gender
     * @return Candidate
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Candidate
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     * @return Candidate
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Candidate
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return Candidate
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Get age
     *
     * @return smallint
     */
    public function getAge()
    {
        $now = new \DateTime();
        return $now->diff($this->dateOfBirth)->y;
    }
    

    /**
     * Set email
     *
     * @param string $email
     * @return Candidate
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone1
     *
     * @param string $phone1
     * @return Candidate
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * Get phone1
     *
     * @return string 
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     * @return Candidate
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string 
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Candidate
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
 
    /**
     * Set picture
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $picture
     * @return Candidate
     */
    public function setPicture(Media $picture = null)
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
     * Set resume
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $resume
     * @return Candidate
     */
    public function setResume(\Application\Sonata\MediaBundle\Entity\Media $resume = null)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getResume()
    {
        return $this->resume;
    }
    
    /**
     * Set origin
     *
     * @param string $origin
     * @return Candidate
     */
    public function setOrigin($origin = null)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set position
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $position
     * @return Candidate
     */
    public function setPosition(\TEW\TPBundle\Entity\CdtePosition $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \TEW\TPBundle\Entity\CdtePosition 
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Set annualIncome
     *
     * @param integer $annualIncome
     * @return Candidate
     */
    public function setAnnualIncome($annualIncome)
    {
        $this->annualIncome = $annualIncome;

        return $this;
    }

    /**
     * Get annualIncome
     *
     * @return integer 
     */
    public function getAnnualIncome()
    {
        return $this->annualIncome;
    }

    /**
     * Set targetPosition1
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $targetPosition1
     * @return Candidate
     */
    public function setTargetPosition1(\TEW\TPBundle\Entity\CdtePosition $targetPosition1 = null)
    {
        $this->targetPosition1 = $targetPosition1;

        return $this;
    }

    /**
     * Get targetPosition1
     *
     * @return \TEW\TPBundle\Entity\CdtePosition 
     */
    public function getTargetPosition1()
    {
        return $this->targetPosition1;
    }

    /**
     * Set targetPosition2
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $targetPosition2
     * @return Candidate
     */
    public function setTargetPosition2(\TEW\TPBundle\Entity\CdtePosition $targetPosition2 = null)
    {
        $this->targetPosition2 = $targetPosition2;

        return $this;
    }

    /**
     * Get targetPosition2
     *
     * @return \TEW\TPBundle\Entity\CdtePosition 
     */
    public function getTargetPosition2()
    {
        return $this->targetPosition2;
    }

    /**
     * Set targetPosition3
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $targetPosition3
     * @return Candidate
     */
    public function setTargetPosition3(\TEW\TPBundle\Entity\CdtePosition $targetPosition3 = null)
    {
        $this->targetPosition3 = $targetPosition3;

        return $this;
    }

    /**
     * Get targetPosition3
     *
     * @return \TEW\TPBundle\Entity\CdtePosition 
     */
    public function getTargetPosition3()
    {
        return $this->targetPosition3;
    }
    
    /**
     * Set creator
     *
     * @param \Application\Sonata\UserBundle\Entity\User $creator
     * @return Candidate
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
     * Add comments
     *
     * @param \TEW\TPBundle\Entity\CdteComment $comments
     * @return Candidate
     */
    public function addComment(\TEW\TPBundle\Entity\CdteComment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \TEW\TPBundle\Entity\CdteComment $comments
     */
    public function removeComment(\TEW\TPBundle\Entity\CdteComment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Returns the collection of tags for this Taggable entity
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();
        return $this->tags;
    }

    /**
     * Used to save tags from a form
     *  
     * @param ArrayCollection $tags
     * @return Candidate
     */ 
    public function setTags($tags)
    {
//        $this->tags = is_array($tags) ? new ArrayCollection($tags) : $tags;
        $this->tags->clear();
        foreach($tags as $tag) {
            $this->tags->add($tag);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */    
    public function getTaggableType()
    {
        return self::TAGGABLE_TYPE;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

    
    /**
     * Get score average
     *
     *  @return float
     */
    public function getScoreAverage()
    {
        $score = 0;
        $nb = 0;
        foreach ($this->comments as $comment) {
            $score += $comment->getScore();
            $nb++;
        }
        return ($nb>0)?$score/$nb:-1;
    }

    /**
     * Add languagesSkills
     *
     * @param \TEW\TPBundle\Entity\CdteLanguage $languagesSkills
     * @return Candidate
     */
    public function addLanguagesSkill(\TEW\TPBundle\Entity\CdteLanguage $languagesSkills)
    {
        $this->languagesSkills[] = $languagesSkills;

        return $this;
    }

    /**
     * Remove languagesSkills
     *
     * @param \TEW\TPBundle\Entity\CdteLanguage $languagesSkills
     */
    public function removeLanguagesSkill(\TEW\TPBundle\Entity\CdteLanguage $languagesSkills)
    {
        $this->languagesSkills->removeElement($languagesSkills);
    }

    /**
     * Get languagesSkills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguagesSkills()
    {
        return $this->languagesSkills;
    }

    /**
     * Add talentpools
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpools
     * @return Candidate
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
     * Add addresses
     *
     * @param \TEW\TPBundle\Entity\Address $addresses
     * @return Candidate
     */
    public function addAddress(\TEW\TPBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \TEW\TPBundle\Entity\Address $addresses
     */
    public function removeAddress(\TEW\TPBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    /**
     * Set addresses
     *
     * @param \TEW\TPBundle\Entity\Address $addresses
     * @return Candidate
     */
    public function setAddresses(ArrayCollection $addresses)
    {
        foreach ($addresses as $address) {
            $address->setCandidate($this);
        }

        $this->address = $addresses;
        return $this->addresses;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Candidate
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
     * Add mobilities
     *
     * @param \TEW\TPBundle\Entity\CdteMobility $mobilities
     * @return Candidate
     */
    public function addMobility(\TEW\TPBundle\Entity\CdteMobility $mobilities)
    {
        $this->mobilities[] = $mobilities;

        return $this;
    }

    /**
     * Remove mobilities
     *
     * @param \TEW\TPBundle\Entity\CdteMobility $mobilities
     */
    public function removeMobility(\TEW\TPBundle\Entity\CdteMobility $mobilities)
    {
        $this->mobilities->removeElement($mobilities);
    }

    /**
     * Get mobilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMobilities()
    {
        return $this->mobilities;
    }
}
