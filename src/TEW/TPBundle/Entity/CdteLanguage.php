<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteLanguage
 * @ORM\Table(name="tew_cdte_language")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteLanguageRepository")
 */
class CdteLanguage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var candidate
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Candidate", inversedBy="languagesSkills")
     * @ORM\JoinColumn(name="candidate_id", nullable=false)
     */
    private $candidate;
    
    /**
     * @var language
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language_id", nullable=false)
     */
    private $language;
    

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
     * Set level
     *
     * @param integer $level
     * @return CdteLanguage
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
     * Set candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return CdteLanguage
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
     * Set language
     *
     * @param \TEW\TPBundle\Entity\Language $language
     * @return CdteLanguage
     */
    public function setLanguage(\TEW\TPBundle\Entity\Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \TEW\TPBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
