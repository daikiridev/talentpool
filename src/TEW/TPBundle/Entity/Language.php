<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 * @ORM\Table(name="tew_language")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\LanguageRepository")
 */
class Language
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
     * @ORM\Column(name="language", type="string", length=128)
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
     * Set language
     *
     * @param string $language
     * @return Language
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
     * To be used by Sonata admin
     *
     * @return string 
     */
    public function __toString()
    {
      return $this->getLanguage();
    }
}
