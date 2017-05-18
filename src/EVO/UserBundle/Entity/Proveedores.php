<?php

namespace EVO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Proveedores
 * @UniqueEntity("email")
 * @UniqueEntity("cIAL")
 * @ORM\Table(name="proveedores")
 * @ORM\Entity(repositoryClass="EVO\UserBundle\Repository\ProveedoresRepository")
 *  @ORM\HasLifecycleCallbacks()
 */
class Proveedores 
{
	
	/**
	 * @ORM\OneToMany(targetEntity="Productos", mappedBy="proveedores")
	 */
	
	protected $productos;
	
	
	/**
	 * @ORM\OneToMany(targetEntity="Pedidos", mappedBy="proveedores")
	 */
	
	protected $pedidos;
	
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Empresa", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="CIAL", type="string", length=9)
     * @Assert\NotBlank()
     */
    private $cIAL;

    /**
     * @var string
     *
     * @ORM\Column(name="Direccion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $direccion;

    /**
     * @var int
     *
     * @ORM\Column(name="Telefono", type="integer")
     * @Assert\NotBlank()
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $descripcion;

    public function __construct()
    {
    	$this->productos = new ArrayCollection();
     
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return Proveedores
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set cIAL
     *
     * @param string $cIAL
     *
     * @return Proveedores
     */
    public function setCIAL($cIAL)
    {
        $this->cIAL = $cIAL;

        return $this;
    }

    /**
     * Get cIAL
     *
     * @return string
     */
    public function getCIAL()
    {
        return $this->cIAL;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Proveedores
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
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Proveedores
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return int
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Proveedores
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Proveedores
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    
    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
    	return $this->productos;
    }
    
    public function getFullName()
    {
    	return $this->empresa;
    }
    
    
    
    /**
     * Add productos
     *
     * @param \EVO\UserBundle\Entity\Productos $productos
     * @return Proveedores
     */
    public function addProductos(\EVO\UserBundle\Entity\Productos $productos)
    {
    	$this->productos[] = $productos;
    
    	return $this;
    }
    
    
    /**
     * Remove productos
     *
     * @param \EVO\UserBundle\Entity\Productos $productos
     */
    public function removeProductos(\EVO\UserBundle\Entity\Productos $productos)
    {
    	$this->productos->removeElement($productos);
    }
  
}

