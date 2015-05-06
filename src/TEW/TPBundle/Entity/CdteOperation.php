<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteOperation
 *
 * @ORM\Table(name="tew_cdte_operation")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteOperationRepository")
 */
class CdteOperation
{
    const STATUS_ANONYMOUS_DETAILS = 'anonymous details';
    const STATUS_CREATE = 'create';
    const STATUS_EDIT = 'edit';
    const STATUS_VIEW = 'view';
    const STATUS_DELETE = 'delete';
    
    const TYPE_USER = 'user';
    const TYPE_SYSTEM = 'system';
    const TYPE_AUTO = 'auto';
    
    /**
     * @var id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var date
     * 
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdAt;

    
    /**
     * @var status
     *
     * @ORM\Column(name="status", type="string", length=127)
     */
    private $status;
    
    /**
     * @var type
     *
     * @ORM\Column(name="type", type="string", length=63)
     */
    private $type;
    
    
    /**
     * @var candidate
     *
     * @ORM\ManyToOne(targetEntity="Candidate")
     * @ORM\JoinColumn(name="candidate_id", nullable=false)
     */
    private $candidate;
    
    /**
     * @var user
     *
     * @ORM\ManyToOne(targetEntity="TEW\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $user;    

    /**
     * @var role
     *
     * @ORM\Column(name="role", type="string", length=63)
     */
    private $role;
    
    

    /**
     * Constructor
     */
    public function __construct(\TEW\UserBundle\Entity\User $user=null)
    {
        $this->createdAt = new \DateTime();
        $this->type = self::TYPE_AUTO;
        $this->user = $user;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CdteOperation
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
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return "[".$this->type."] Candidate ".$this->status." (by ".$this->getUser()->getFullname().")";
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CdteOperation
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_ANONYMOUS_DETAILS, self::STATUS_CREATE, self::STATUS_EDIT, self::STATUS_VIEW, self::STATUS_DELETE))) {
            throw new \InvalidArgumentException("Invalid status for candidate operation: $status");
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set role
     *
     * @param string $role
     * @return CdteOperation
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return CdteOperation
     */
    public function setCandidate(\TEW\TPBundle\Entity\Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return \TEW\TPBundle\Entity\Candidate 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set user
     *
     * @param \TEW\UserBundle\Entity\User $user
     * @return CdteOperation
     */
    public function setUser(\TEW\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TEW\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return CdteOperation
     */
    public function setType($type)
    {
        if (!in_array($type, array(self::TYPE_USER, self::TYPE_SYSTEM, self::TYPE_AUTO))) {
            throw new \InvalidArgumentException("Invalid type for candidate operation: $type");
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
