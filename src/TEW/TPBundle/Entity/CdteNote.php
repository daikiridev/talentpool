<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CdteNote
 * @ORM\Table(name="tew_cdte_note")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteNoteRepository")
 */
class CdteNote
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
     * @ORM\Column(name="note", type="text", length=null)
     */
    private $note;


    /**
     * @var date
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var candidate
     *
     * @ORM\ManyToOne(targetEntity="Candidate", inversedBy="notes")
     * @ORM\JoinColumn(name="candidate_id", nullable=false, referencedColumnName="id")
     */
    private $candidate;
    
    /**
     * @var author
     *
     * @ORM\ManyToOne(targetEntity="TEW\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id")
     */
    private $author;
  
    /**
     * Get id
     *
     * @return integer 
     */
    
    /**
     * Constructor
     */
    public function __construct(\TEW\UserBundle\Entity\User $user=null)
    {
        $this->date = new \DateTime();
        $this->author = $user;
    }
    
    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        // return $this->getName().' (created by '.$this->getCreator()->getUsername().')';
        return $this->getTitle();
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }


    /**
     * Set date
     *
     * @return Note
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
     * @return CdteNote
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
     * @return CdteNote
     */
    public function setAuthor(\TEW\UserBundle\Entity\User $user = null)
    {
        $this->author = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TEW\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    

    /**
     * Set title
     *
     * @param string $title
     * @return CdteNote
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
