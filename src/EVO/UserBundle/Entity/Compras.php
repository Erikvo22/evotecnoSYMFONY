<?php

namespace EVO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Compras
 *
 * @ORM\Table(name="compras")
 * @ORM\Entity(repositoryClass="EVO\UserBundle\Repository\ComprasRepository")
 */
class Compras
{
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="compras")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	
	protected $user;
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="Productos", inversedBy="compras")
	 * @ORM\JoinColumn(name="productos_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	
	protected $productos;
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fechacomp", type="date")
     * @Assert\NotBlank()
     */
    private $fechacomp;

    /**
     * @var int
     *
     * @ORM\Column(name="preciototal", type="integer")
     * @Assert\NotBlank()
     */
    private $preciototal;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     * @Assert\NotBlank()
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $direccion;

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
     * Set fechacomp
     *
     * @param \DateTime $fechacomp
     *
     * @return Compras
     */
    public function setFechacomp($fechacomp)
    {
        $this->fechacomp = $fechacomp;

        return $this;
    }

    /**
     * Get fechacomp
     *
     * @return \DateTime
     */
    public function getFechacomp()
    {
        return $this->fechacomp;
    }

    /**
     * Set preciototal
     *
     * @param integer $preciototal
     *
     * @return Compras
     */
    public function setPreciototal($preciototal)
    {
        $this->preciototal = $preciototal;

        return $this;
    }

    /**
     * Get preciototal
     *
     * @return int
     */
    public function getPreciototal()
    {
        return $this->preciototal;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Compras
     */
    public function setCantidad($cantidad)
    {
    	$this->cantidad = $cantidad;
    
    	return $this;
    }
    
    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
    	return $this->cantidad;
    }
    
    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Compras
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
     * Set productos
     *
     * @param \EVO\UserBundle\Entity\Productos $productos
     * @return Compras
     */
    public function setProductos(\EVO\UserBundle\Entity\Productos $productos = null)
    {
    	$this->productos = $productos;
    
    	return $this;
    }
    
    /**
     * Get productos
     *
     * @return \EVO\UserBundle\Entity\Productos
     */
    public function getProductos()
    {
    	return $this->productos;
    }
    
    
    
    
    /**
     * Set user
     *
     * @param \EVO\UserBundle\Entity\User $user
     * @return Compras
     */
    public function setUser(\EVO\UserBundle\Entity\User $user = null)
    {
    	$this->user = $user;
    
    	return $this;
    }
    
    /**
     * Get user
     *
     * @return \EVO\UserBundle\Entity\User
     */
    public function getUser()
    {
    	return $this->user;
    }
}

