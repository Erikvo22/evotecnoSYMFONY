<?php

namespace EVO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos")
 * @ORM\Entity(repositoryClass="EVO\UserBundle\Repository\PedidosRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Pedidos
{
	
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="Proveedores", inversedBy="pedidos")
	 * @ORM\JoinColumn(name="proveedores_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	
	protected $proveedores;
	
	

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="Productos", inversedBy="pedidos")
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
     * @ORM\Column(name="Fechapedido", type="date")
     * @Assert\NotBlank()
     */
    private $fechapedido;

    /**
     * @var int
     *
     * @ORM\Column(name="Cantidad", type="integer")
     * @Assert\NotBlank()
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="Otros", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $otros;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     
     */
    private $status;


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
     * Set fechapedido
     *
     * @param \DateTime $fechapedido
     *
     * @return Pedidos
     */
    public function setFechapedido($fechapedido)
    {
        $this->fechapedido = $fechapedido;

        return $this;
    }

    /**
     * Get fechapedido
     *
     * @return \DateTime
     */
    public function getFechapedido()
    {
        return $this->fechapedido;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Pedidos
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
     * Set otros
     *
     * @param string $otros
     *
     * @return Pedidos
     */
    public function setOtros($otros)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros
     *
     * @return string
     */
    public function getOtros()
    {
        return $this->otros;
    }
    
    /**
     * Set status
     *
     * @param boolean $status
     * @return Pedidos
     */
    public function setStatus($status)
    {
    	$this->status = $status;
    
    	return $this;
    }
    
    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
    	return $this->status;
    }
    
    
    /**
     * Set proveedores
     *
     * @param \EVO\UserBundle\Entity\Proveedores $proveedores
     * @return Pedidos
     */
    public function setProveedores(\EVO\UserBundle\Entity\Proveedores $proveedores = null)
    {
    	$this->proveedores = $proveedores;
    
    	return $this;
    }
    
    /**
     * Get proveedores
     *
     * @return \EVO\UserBundle\Entity\Proveedores
     */
    public function getProveedores()
    {
    	return $this->proveedores;
    }
    
    
    
    /**
     * Set productos
     *
     * @param \EVO\UserBundle\Entity\Productos $productos
     * @return Pedidos
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
}

