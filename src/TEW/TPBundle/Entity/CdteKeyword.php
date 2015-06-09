<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteKeyword
 *
 * @ORM\Table(name="tew_cdtekeyword")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteKeywordRepository")
 */
class CdteKeyword
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
     * @ORM\Column(name="name", type="string", length=127)
     */
    private $name;
    
    /**
     * @var companies
     * 
     * @ORM\ManyToMany(targetEntity="Company", mappedBy="keywords")
     * 
     */
    private $companies;


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
     * @return CdteKeyword
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
     * To be used by Sonata admin
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->getName();
    }    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->companies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add companies
     *
     * @param \TEW\TPBundle\Entity\Company $companies
     * @return CdteKeyword
     */
    public function addCompany(\TEW\TPBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \TEW\TPBundle\Entity\Company $companies
     */
    public function removeCompany(\TEW\TPBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompanies()
    {
        return $this->companies;
    }
}
