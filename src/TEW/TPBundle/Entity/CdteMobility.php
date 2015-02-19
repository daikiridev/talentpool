<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdteMobility
 *
 * @ORM\Table(name="tew_cdtemobility")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\CdteMobilityRepository")
 */
class CdteMobility
{
    /**
     * @var id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;
    
    /**
     * @var candidate
     *
     * @ORM\ManyToOne(targetEntity="Candidate", inversedBy="mobilities")
     * @ORM\JoinColumn(name="candidate_id", nullable=false, referencedColumnName="id")
     */
    private $candidate;

    /**
     * @var zone
     *
     * @ORM\Column(name="zone", type="string", length=7, nullable=true)
     */
    private $zone;
    
    /**
     * @var country
     *
     * @ORM\Column(name="country", type="string", length=7, nullable=true)
     */
    private $country;

    /**
     * @var region
     *
     * @ORM\Column(name="region", type="string", length=7, nullable=true)
     */
    private $region;
    
    /**
     * @var city
     *
     * @ORM\Column(name="city", type="string", length=7, nullable=true)
     */
    private $city;

    /**
     * Constructor
     */
   
    /*
    public function __construct(\Application\Sonata\UserBundle\Entity\User $user=null)
    {
//        $this->user = $user;
    }
     * 
     */
     
    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getLocation();
    }
    
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
     * Set zone
     *
     * @param string $zone
     * @return CdteMobility
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return CdteMobility
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return CdteMobility
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return CdteMobility
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return CdteMobility
     */
    public function setCandidate(\TEW\TPBundle\Entity\Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return \TEW\TPBundle\Entity\Candidate 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return CdteMobility
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
}
