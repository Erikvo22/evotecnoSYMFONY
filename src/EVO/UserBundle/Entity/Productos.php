<?php

namespace EVO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Productos
 * @UniqueEntity("nombre")
 * @ORM\Table(name="productos")
 * @ORM\Entity(repositoryClass="EVO\UserBundle\Repository\ProductosRepository")
 *  @ORM\HasLifecycleCallbacks()
 */
class Productos
{
	
	
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="Proveedores", inversedBy="productos")
	 * @ORM\JoinColumn(name="proveedores_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	
	protected $proveedores;
	
	
	/**
	 * @ORM\OneToMany(targetEntity="Pedidos", mappedBy="productos")
	 */
	
	protected $pedidos;
	
	
	/**
	 * @ORM\OneToMany(targetEntity="Compras", mappedBy="productos")
	 */
	
	protected $compras;
	
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
     * @ORM\Column(name="Nombre", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $descripcion;

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
     * @ORM\Column(name="Preciocomp", type="decimal", precision=5, scale=0)
     * @Assert\NotBlank()
     */
    private $preciocomp;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Preciov", type="decimal", precision=5, scale=0)
     * @Assert\NotBlank()
     */
    private $preciov;

    /**
     * @var string
     *
     * @ORM\Column(name="Tipo", type="string",columnDefinition="ENUM( 'Moviles y SmarthPhone', 'Informatica','Grandes electrodomesticos',
     * 'Pequenos electrodomesticos', 'TV', 'Sonido', 'Fotografia y video', 'Consolas y juegos', 'Electronica deportiva y drone')", length=100)
     * @Assert\NotBlank()
     */
    private $tipo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Img", type="string", length=250, nullable=true)
     * @Assert\NotBlank()
     */
    private $img;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Productos
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Productos
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
     * Set cantidad
     *
     * @param int $cantidad
     *
     * @return Productos
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
     * Set preciocomp
     *
     * @param string $preciocomp
     *
     * @return Productos
     */
    public function setPreciocomp($preciocomp)
    {
    	$this->preciocomp = $preciocomp;
    
    	return $this;
    }
    
    /**
     * Get preciocomp
     *
     * @return string
     */
    public function getPreciocomp()
    {
    	return $this->preciocomp;
    }
    
    

    /**
     * Set preciov
     *
     * @param string $preciov
     *
     * @return Productos
     */
    public function setPreciov($preciov)
    {
        $this->preciov = $preciov;

        return $this;
    }

    /**
     * Get preciov
     *
     * @return string
     */
    public function getPreciov()
    {
        return $this->preciov;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Productos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

  
    /**
     * Set img
     *
     * @param string $img
     *
     * @return Productos
     */
    public function setImg($img)
    {
    	$this->img = $img;
    
    	return $this;
    }
    
    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
    	return $this->img;
    }
    
    
    /**
     * Set proveedores
     *
     * @param \EVO\UserBundle\Entity\Proveedores $proveedores
     * @return Productos
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
    
    

    
   
}

