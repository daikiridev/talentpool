<?php

namespace TEW\TPBundle\Entity;

use \FPN\TagBundle\Entity\Tag as BaseTag;
use Doctrine\ORM\Mapping as ORM;

/**
 * TEW\TPBundle\Entity\Tag
 *
 * @ORM\Table(name="tew_tag")
 * @ORM\Entity
 */
class Tag extends BaseTag {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=50)
     */
    protected $slug;

//    /**
//     * @var candidates
//     * 
//     * @ORM\ManyToMany(targetEntity="Candidate")
//     * @ORM\JoinTable(name="tew_cdte_tags",
//     *  joinColumns={@ORM\JoinColumn(name="candidate_id", referencedColumnName="id")},
//     *  inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
//     *  )
//     */
//    private $candidates;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag", fetch="EAGER")
     * */
    protected $tagging;

    /**
     * Constructor
     */
    public function __construct($name = null) {
        parent::__construct($name);
        $this->tagging = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add tagging
     *
     * @param \TEW\TPBundle\Entity\Tagging $tagging
     * @return Tag
     */
    public function addTagging(\TEW\TPBundle\Entity\Tagging $tagging) {
        $this->tagging[] = $tagging;

        return $this;
    }

    /**
     * Remove tagging
     *
     * @param \TEW\TPBundle\Entity\Tagging $tagging
     */
    public function removeTagging(\TEW\TPBundle\Entity\Tagging $tagging) {
        $this->tagging->removeElement($tagging);
    }

    /**
     * Get tagging
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagging() {
        return $this->tagging;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Tag
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
     * Set slug
     *
     * @param string $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tag
     */
    public function setCreatedAt(\DateTime $createdAt)
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Tag
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
