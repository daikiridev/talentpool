<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteProfile
 *
 * @ORM\Table(name="tew_cdteprofile")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteProfileRepository")
 */
class CdteProfile
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdtePosition")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id", nullable=false)
     */

    private $position;
    
    /**
     * @var talentpool
     * 
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\TalentPool", inversedBy="profiles")
     *  @ORM\JoinTable(name="tew_talentpool_profiles")
     */
    private $talentpool;
    

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
     * Set title
     *
     * @param string $title
     * @return CdteProfile
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

    /**
     * Set description
     *
     * @param string $description
     * @return CdteProfile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param \TEW\TPBundle\Entity\CdtePosition $position
     * @return CdteProfile
     */
    public function setPosition(\TEW\TPBundle\Entity\CdtePosition $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \TEW\TPBundle\Entity\CdtePosition 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set talentpool
     *
     * @param \TEW\TPBundle\Entity\TalentPool $talentpool
     * @return CdteProfile
     */
    public function setTalentpool(\TEW\TPBundle\Entity\TalentPool $talentpool = null)
    {
        $this->talentpool = $talentpool;

        return $this;
    }

    /**
     * Get talentpool
     *
     * @return \TEW\TPBundle\Entity\TalentPool 
     */
    public function getTalentpool()
    {
        return $this->talentpool;
    }
}
