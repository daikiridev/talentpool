<?php

namespace TEW\TPBundle\Entity;

//# Tag management
//use Fogs\TaggingBundle\Interfaces\Taggable;
//use Fogs\TaggingBundle\Traits\TaggableTrait;

// ORM mapping
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 * 
 * @ORM\Table(name="tew_candidate")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CandidateRepository")
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
     * @ORM\Column(name="middlename", type="string", length=127)
     */
    private $middleName = '';

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
     * @ORM\Column(name="phone2", type="string", length=31)
     */
    private $phone2;
    
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
     * @var targetPositions
     * 
     * @ORM\ManyToMany(targetEntity="CdtePosition")
     * @ORM\JoinTable(name="tew_cdte_targetpositions",
     *  joinColumns={@ORM\JoinColumn(name="position_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="candidate_id", referencedColumnName="id")}
     *  )
     */
    private $targetPositions;
    
    /**
     * @var languagesSkills
     * 
     * @ORM\OneToMany(targetEntity="CdteLanguage", mappedBy="candidate")
     */
    private $languagesSkills; 
    
    /**
     * @var talentpools
     * 
     * @ORM\ManyToMany(targetEntity="TalentPool", mappedBy="candidates")
     */
    private $talentpools;
    
    /**
     * level: years of experience
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;
    
    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=127)
     */
    private $origin;
    
    /**
     * @var comments
     *
     * @ORM\OneToMany(targetEntity="CdteComment", mappedBy="candidate")   
     * 
     */
    private $comments;
    
    /**
     * @var tags
     * 
     */
    private $tags;

    /**
     * @var date
     * 
     * @ORM\Column(name="creationdate", type="datetime")
     */
    private $creationDate;
  
    /**
     * @var creator
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Candidate
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
     * Add targetPositions
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $targetPositions
     * @return Candidate
     */
    public function addTargetPosition(\TEW\TPBundle\Entity\CdtePosition $targetPositions)
    {
        $this->targetPositions[] = $targetPositions;

        return $this;
    }

    /**
     * Remove targetPositions
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $targetPositions
     */
    public function removeTargetPosition(\TEW\TPBundle\Entity\CdtePosition $targetPositions)
    {
        $this->targetPositions->removeElement($targetPositions);
    }

    /**
     * Get targetPositions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTargetPositions()
    {
        return $this->targetPositions;
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
     * @return Tag[]
     */
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    /**
     * Used to save tags from a form
     *  
     * @param \TEW\TPBundle\Entity\CdteComment $comments
     * @return Candidate
     */
    // We added this to be able to save tags from a form  
    public function setTags($tags)
    {
        $this->tags = is_array($tags) ? new ArrayCollection($tags) : $tags;
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
     * Constructor
     */
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user=null)
    {
        $this->targetPositions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languagesSkills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->talentpools = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->getLastName().' '.$this->getFirstName().' '.$this->getMiddleName().' ('.$this->getGender().')';
    }

}
