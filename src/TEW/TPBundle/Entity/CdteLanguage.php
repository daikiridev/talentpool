<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\EntityRepository;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CdteLanguage
 * @ORM\Table(name="tew_cdtelanguageskill")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteLanguageRepository")
 * @UniqueEntity(fields={"language", "skill"})
 */
class CdteLanguage
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
     *
     * @var string
     * @ORM\Column(name="language", type="string", length=15)
     */
    private $language;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="skill", type="smallint")
     */
    private $skill;


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
     * Set language
     *
     * @param string $language
     * @return CdteLanguage
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set skill
     *
     * @param integer $skill
     * @return CdteLanguage
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return integer 
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        // return $repository->getAllLanguages()[$this->getLanguage()].' '.$repository->getSkills()[$this->getSkill()];
        return $this->getLanguage().': '.$this->getSkill();
    }
}
