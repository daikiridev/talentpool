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
     *      @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=false)
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
     * @var date
     * 
     * @ORM\Column(name="lastactivity", type="datetime", nullable=true)
     */
    private $lastActivity;

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
    
    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

//        foreach ($this->getGroups() as $group) {
//            $roles = array_merge($roles, $group->getRoles());
//        }

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }
    
    /**
     * Get LastActivity
     *
     * @return date
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }
    
    /**
     * Set lastActivity
     *
     * @param \DateTime $date
     * @return User
     */
    public function setLastActivity($date)
    {
        $this->lastActivity = $date;

        return $this;
    }
    
    /**
     * isActiveNow
     *
     * @param \DateTime $date
     * @return User
     */
    public function isActiveNow()
    {
        $this->setLastActivity(new \DateTime);

        return $this;
    }
}
