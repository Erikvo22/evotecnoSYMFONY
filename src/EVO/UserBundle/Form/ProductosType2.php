<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class ProductosType2 extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('cantidad')
            ->add('preciocomp')
            ->add('preciov')
            ->add('tipo', 'choice', array('choices' => array('Moviles y SmarthPhone' => 'Moviles y SmarthPhone', 'Informatica' => 'Informatica','Grandes electrodomesticos' => 'Grandes electromesticos',
            		'Pequenos electrodomesticos' => 'Pequenos electrodomesticos', 'TV' => 'TV', 'Sonido' => 'Sonido', 'Fotografia y video' => 'Fotografia y video', 'Consolas y juegos' => 'Consolas y juegos', 'Electronica deportiva y drone' => 'Electronica deportiva y drone')))
            ->add('proveedores', 'entity', array(
            		'class' => 'EVOUserBundle:Proveedores',
            		'choice_label' => 'getEmpresa'
            				))
         
       
            ->add('save', 'submit', array('label' => 'Guardar tarea'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\Productos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'productos';
    }
}
