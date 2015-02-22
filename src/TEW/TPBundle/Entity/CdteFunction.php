<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteFunction
 *
 * @ORM\Table(name="tew_cdtefunction")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteFunctionRepository")
 */
class CdteFunction {

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
     * @ORM\OneToMany(targetEntity="CdteFunction", mappedBy="parent")
     * */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="CdteFunction", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id")
     * */
    private $parent;
    
    /**
     * To be used by Sonata admin
     *
     * @return string 
     */
    public function __toString() {
        return $this?$this->getName():'';
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CdteFunction
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $parent
     * @return CdteFunction
     */
    public function setParent(\TEW\TPBundle\Entity\CdteFunction $parent = null) {
        $this->parent = $parent;
        $parent->addChild($this);
        return $this;
    }

    /**
     * Get parent
     *
     * @return \TEW\TPBundle\Entity\CdteFunction 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $children
     * @return CdteFunction
     */
    public function addChild(\TEW\TPBundle\Entity\CdteFunction $children) {
        $this->children[] = $children;
        $children->setParent($this);
        return $this;
    }

    /**
     * Remove children
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $children
     */
    public function removeChild(\TEW\TPBundle\Entity\CdteFunction $children) {
        $this->children->removeElement($children);
        $children->setParent(null);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren() {
        return $this->children;
    }


}
