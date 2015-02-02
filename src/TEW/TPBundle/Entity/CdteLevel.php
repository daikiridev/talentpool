<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteLevel
 *
 * @ORM\Table(name="tew_cdtelevel")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteLevelRepository")
 */
class CdteLevel
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
     * @return CdteLevel
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
}
