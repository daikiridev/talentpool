<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CdteFunction
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="tew_cdtefunction")
 * // @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteFunctionRepository")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
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
    
    private $identedName;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;
    
    /**
     * @ORM\OneToMany(targetEntity="CdteFunction", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="CdteFunction", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
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

//    /**
//     * Constructor
//     */
//    public function __construct() {
//        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
//    }
    
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
    
    public function getIndentedName() {
        return str_repeat($this->parent." > ", $this->lvl) . $this->name;
    }

    /**
     * Set parent
     *
     * @param \TEW\TPBundle\Entity\CdteFunction $parent
     * @return CdteFunction
     */
    public function setParent(\TEW\TPBundle\Entity\CdteFunction $parent = null) {
        $this->parent = $parent;
        //$parent->addChild($this);
        $this->lvl = $parent->lvl+1;
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

//    /**
//     * Add children
//     *
//     * @param \TEW\TPBundle\Entity\CdteFunction $children
//     * @return CdteFunction
//     */
//    public function addChild(\TEW\TPBundle\Entity\CdteFunction $children) {
//        $this->children[] = $children;
//        $children->setParent($this);
//        return $this;
//    }
//
//    /**
//     * Remove children
//     *
//     * @param \TEW\TPBundle\Entity\CdteFunction $children
//     */
//    public function removeChild(\TEW\TPBundle\Entity\CdteFunction $children) {
//        $this->children->removeElement($children);
//        $children->setParent(null);
//    }
//
//    /**
//     * Get children
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getChildren() {
//        return $this->children;
//    }
//
//
//
//    /**
//     * Set lft
//     *
//     * @param integer $lft
//     * @return CdteFunction
//     */
//    public function setLft($lft)
//    {
//        $this->lft = $lft;
//
//        return $this;
//    }
//
//    /**
//     * Get lft
//     *
//     * @return integer 
//     */
//    public function getLft()
//    {
//        return $this->lft;
//    }
//
//    /**
//     * Set lvl
//     *
//     * @param integer $lvl
//     * @return CdteFunction
//     */
//    public function setLvl($lvl)
//    {
//        $this->lvl = $lvl;
//
//        return $this;
//    }
//
//    /**
//     * Get lvl
//     *
//     * @return integer 
//     */
//    public function getLvl()
//    {
//        return $this->lvl;
//    }
//
//    /**
//     * Set rgt
//     *
//     * @param integer $rgt
//     * @return CdteFunction
//     */
//    public function setRgt($rgt)
//    {
//        $this->rgt = $rgt;
//
//        return $this;
//    }
//
//    /**
//     * Get rgt
//     *
//     * @return integer 
//     */
//    public function getRgt()
//    {
//        return $this->rgt;
//    }
//
//    /**
//     * Set root
//     *
//     * @param integer $root
//     * @return CdteFunction
//     */
//    public function setRoot($root)
//    {
//        $this->root = $root;
//
//        return $this;
//    }
//
//    /**
//     * Get root
//     *
//     * @return integer 
//     */
//    public function getRoot()
//    {
//        return $this->root;
//    }
}
