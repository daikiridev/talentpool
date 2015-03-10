<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfileMobility
 *
 * @ORM\Table(name="tew_profile_mobility")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\ProfileMobilityRepository")
 */
class ProfileMobility
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
     * @var profile
     *
     * @ORM\ManyToOne(targetEntity="CdteProfile", inversedBy="locations")
     * @ORM\JoinColumn(name="profile_id", nullable=false, referencedColumnName="id")
     */
    private $profile;

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
     * @return ProfileMobility
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
     * @return ProfileMobility
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
     * @return ProfileMobility
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
     * @return ProfileMobility
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
     * Set profile
     *
     * @param \TEW\TPBundle\Entity\CdteProfile $profile
     * @return ProfileMobility
     */
    public function setCdteProfile(\TEW\TPBundle\Entity\CdteProfile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \TEW\TPBundle\Entity\CdteProfile 
     */
    public function getCdteProfile()
    {
        return $this->profile;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return ProfileMobility
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

    /**
     * Set profile
     *
     * @param \TEW\TPBundle\Entity\CdteProfile $profile
     * @return ProfileMobility
     */
    public function setProfile(\TEW\TPBundle\Entity\CdteProfile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \TEW\TPBundle\Entity\CdteProfile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
