<?php

namespace TEW\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user_user")
 * @ORM\Entity(repositoryClass="TEW\UserBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var company
     *
     * @ORM\ManyToOne(targetEntity="\TEW\TPBundle\Entity\Company", inversedBy="users")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
     *  })
     */
    protected $company;

    /**
     * @ORM\ManyToMany(targetEntity="\TEW\UserBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Get company
     *
     * @return \TEW\TPBundle\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }
    
    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }



    /**
     * Set company
     *
     * @param \TEW\TPBundle\Entity\Company $company
     * @return User
     */
    public function setCompany(\TEW\TPBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }
}
