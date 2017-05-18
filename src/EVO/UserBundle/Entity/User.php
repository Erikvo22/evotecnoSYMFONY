<?php

namespace EVO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
 * User
 *
 * @ORM\Table(name = "users")
 * @ORM\Entity(repositoryClass="EVO\UserBundle\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, \Serializable
{
	/**
	 * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
	 */
	
	protected $tasks; 
	
	
	/**
	 * @ORM\OneToMany(targetEntity="Compras", mappedBy="user")
	 */
	
	protected $compras;
	
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
     * @ORM\Column(name="nombre", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nombre;

    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $username;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=9)
     * @Assert\NotBlank()
     */
    private $dni;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer")
     * @Assert\NotBlank()
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="fnac", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $fnac;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
  	 * @ORM\Column(name="role", type="string",columnDefinition="ENUM( 'ROLE_USER', 'ROLE_ADMIN','ROLE_EMPLEADO')", length=255)
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
   
    

    public function __construct()
    {
    	$this->tasks = new ArrayCollection();
    	$this->isActive = true;
    	
    	
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
    	$this->username = $username;
    	return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
    	return $this->username;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return User
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return User
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return User
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return User
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return User
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set fnac
     *
     * @param string $fnac
     * @return User
     */
    public function setFnac($fnac)
    {
        $this->fnac = $fnac;

        return $this;
    }

    /**
     * Get fnac
     *
     * @return string 
     */
    public function getFnac()
    {
        return $this->fnac;
    }
    
    
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
    	$this->isActive = $isActive;
    	return $this;
    }
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
    	return $this->isActive;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
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
     * @return User
     */
    public function setUpdatedAt($updatedAt)
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
    
    
    
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
    	$this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    
    public function setUpdatedAtValue()
    {
    	$this->updatedAt = new \DateTime();
    }
    
  
    
    public function getRoles()
    {
    	return array($this->role);
    }
    
    public function getSalt()
    {
    	return null;
    }
    
    public function eraseCredentials()
    {
    
    }
 
   

    /**
     * Add tasks
     *
     * @param \EVO\UserBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\EVO\UserBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \EVO\UserBundle\Entity\Task $tasks
     */
    public function removeTask(\EVO\UserBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
    
    public function getFullName()
    {
    	return $this->nombre . " " . $this->apellidos;
    }
    
   
    
    /**@see \Serializable::serialize() */
    public function serialize()
    {
    	return serialize(array(
    		$this->id,
    		$this->username,
    		$this->password,
    		$this->isActive
    			
    	));
    }
    
    
    /**@see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
    	list(
    			$this->id,
    			$this->username,
    			$this->password,
    			$this->isActive
    			 
    	) = unserialize($serialized);
    }
    
    
    
    public function isAccountNonExpired()
    {
    	return true;
    }
    public function isAccountNonLocked()
    {
    	return true;
    }
    public function isCredentialsNonExpired()
    {
    	return true;
    }
    
    public function isEnabled()
    {
    	return $this->isActive;
    }
    
    
   
}
