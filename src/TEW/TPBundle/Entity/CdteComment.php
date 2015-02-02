<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteComment
 * @ORM\Table(name="tew_cdte_comment")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteCommentRepository")
 */
class CdteComment
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
     * @ORM\Column(name="title", type="string", length=127)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=null)
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="smallint")
     */
    private $score;

    /**
     * @var date
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var candidate
     *
     * @ORM\ManyToOne(targetEntity="Candidate", inversedBy="comments")
     * @ORM\JoinColumn(name="candidate_id", nullable=false, referencedColumnName="id")
     */
    private $candidate;
    
    /**
     * @var user
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id")
     */
    private $user;

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
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Comment
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set date
     *
     * @return Comment
     */
    public function setDate()
    {
        if (!$this->getDate()) {
            $this->date = new \DateTime();
        }
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return CdteComment
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
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return CdteComment
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Constructor
     */
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->date = new \DateTime();
        $this->user = $user;
    } 

    /**
     * Set title
     *
     * @param string $title
     * @return CdteComment
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
}
