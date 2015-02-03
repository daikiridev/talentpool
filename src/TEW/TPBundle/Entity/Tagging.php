<?php

//
// WARNING: do not generate this entity via doctrine:generate:entites
// as it produces an ContextErrorException: Runtime Notice: Declaration of TEW\TPBundle\Entity\Tagging::setTag()
// should be compatible with DoctrineExtensions\Taggable\Entity\Tagging::setTag(DoctrineExtensions\Taggable\Entity\Tag $tag)

namespace TEW\TPBundle\Entity;

use \FPN\TagBundle\Entity\Tagging as BaseTagging;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * TEW\TPBundle\Entity\Tagging
 *
 * @ORM\Table(name="tew_tagging", uniqueConstraints={@UniqueConstraint(name="tagging_idx", columns={"tag_id", "resource_type", "resource_id"})})
 * @ORM\Entity
 */
class Tagging extends BaseTagging {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="tagging")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * */
    protected $tag;

    /**
     * @var string
     * @ORM\Column(name="resource_type", type="string", length=50)
     */
    protected $resourceType;

    /**
     * @var string
     * @ORM\Column(name="resource_id", type="string", length=50)
     */
    protected $resourceId;

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
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set resourceType
     *
     * @param string $resourceType
     * @return Tagging
     */
    public function setResourceType($resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    /**
     * Get resourceType
     *
     * @return string 
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Set resourceId
     *
     * @param string $resourceId
     * @return Tagging
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * Get resourceId
     *
     * @return string 
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tagging
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
     * @return Tagging
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
