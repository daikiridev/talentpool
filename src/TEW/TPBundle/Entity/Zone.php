<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table(name="tew_zone")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\ZoneRepository")
 */
class Zone
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=7)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=127)
     */
    private $fullname;


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
     * Set fullname
     *
     * @param string $fullname
     * @return Zone
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Zone
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
