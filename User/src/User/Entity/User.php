<?php

/**
 * @author eDruk ICT <edruk@edruk.com.bt>
 * @link http://web.edruk.com.bt
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Zend\Form\Annotation; // !!!! Absolutely neccessary

/**
 * User Doctroine Entity Class 
 * @ORM\Entity
 * @ORM\Table(name="users")	
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;   


    /**
     * @ORM\Column(name="username", length=100)
     */
    protected $username;

    /**
     * @ORM\Column(name="password", length=100)
     */
    protected $password;

    /**
     * @ORM\Column(name="role", length=255)
     */
    
    protected $role;
	
	/**
     * @ORM\Column(name="region", length=40)
     */
    protected $region;

    /**
     * @ORM\Column(name="user_type_id", type="integer", length=11)
     * @Annotation\Attributes({"type":"text"})
     */   
   protected $user_type_id;

	/**
     * @ORM\Column(name="user_status_id", type="integer", length=11)
     */
    protected $user_status_id; 

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $last_login; 

    
    /**
     * Magic getter to expose protected properties.
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Populate from an array.
     * @param array $data
     */
    public function populate($data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists(__class__, $key))
                $this->$key = $value;
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole(Role $role) {
        $this->roles[] = $role;
    }

    /**
     * Add roles to the user.
     * 
     * @param unknown $roles
     */
    public function addRoles($roles) {
        foreach ($roles as $curRole) {
            $this->roles->add($curRole);
        }
    }

    /**
     * Remove roles from user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function removeRoles($roles) {
        foreach ($roles as $curRole) {
            $this->roles->removeElement($curRole);
        }
    }

    /**
     * Sets the role to the one specified. All other roles are cleared.
     * 
     * @param Role $role
     */
    public function updateRole(Role $role) {
        $this->roles->clear();
        $this->roles[] = $role;
    }

    /**
     * Returns the first role of this user.
     * @return \BloomtubeUser\Entity\Role | null
     */
    public function getRole() {
        $roles = $this->getRoles();

        if ($roles && (is_array($roles)) && count($roles) > 0) {
            return $roles[0];
        } else {
            return null;
        }
    }

}
