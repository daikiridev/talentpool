<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="tew_address")
 * @ORM\Entity(repositoryClass="TEW\TPBundle\Entity\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="street1", type="string", length=255)
     */
    private $street1;

    /**
     * @var string
     *
     * @ORM\Column(name="street2", type="string", length=255, nullable=true)
     */
    private $street2;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=7)
     */
    private $zip;


    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdteCity")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
     */
    private $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdteRegion")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=true)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\CdteCountry")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    private $country;
    
    /**
     * @var \DCS\Form\SelectCityFormFieldBundle\Model\SelectData
     */
    protected $selectData;

    /**
     * @ORM\ManyToOne(targetEntity="TEW\TPBundle\Entity\Candidate", inversedBy="addresses")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id", nullable=true)
     */
    private $candidate;    

    /**
     * Set selectData
     *
     * @param \DCS\Form\SelectCityFormFieldBundle\Model\SelectData $selectData
     * @return Address
     */
    public function setSelectData(\DCS\Form\SelectCityFormFieldBundle\Model\SelectData $selectData)
    {
        $this->setCountry($selectData->getCountry());
        $this->setRegion($selectData->getRegion());
        $this->setCity($selectData->getCity());

        $this->selectData = $selectData;

        return $this;
    }

    /**
     * Get selectData
     *
     * @return \DCS\Form\SelectCityFormFieldBundle\Model\SelectData
     */
    public function getSelectData()
    {
        $selectData = new \DCS\Form\SelectCityFormFieldBundle\Model\SelectData();
        $selectData->setCountry($this->getCountry());
        $selectData->setRegion($this->getRegion());
        $selectData->setCity($this->getCity());

        return $selectData;
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
     * Set label
     *
     * @param string $label
     * @return Address
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set street1
     *
     * @param string $street1
     * @return Address
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;

        return $this;
    }

    /**
     * Get street1
     *
     * @return string 
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Set street2
     *
     * @param string $street2
     * @return Address
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Get street2
     *
     * @return string 
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Address
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
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
     * Set country
     *
     * @param \stdClass $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \stdClass 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param \TEW\TPBundle\Entity\CdteRegion $region
     * @return Address
     */
    public function setRegion(\TEW\TPBundle\Entity\CdteRegion $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \TEW\TPBundle\Entity\CdteRegion 
     */
    public function getRegion()
    {
        return $this->region;
    }


    /**
     * Set candidate
     *
     * @param \TEW\TPBundle\Entity\Candidate $candidate
     * @return Address
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
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}
