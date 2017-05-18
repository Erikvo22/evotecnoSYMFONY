<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;



class PedidosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productos', 'entity', array(
            		'class' => 'EVOUserBundle:Productos',
            		'choice_label' => 'getNombre'
            				))
            ->add('proveedores', 'entity', array(
            		'class' => 'EVOUserBundle:Proveedores',
            		'choice_label' => 'getEmpresa'
            				))
            ->add('fechapedido')
            ->add('cantidad')
            ->add('otros')
       
            ->add('save', 'submit', array('label' => 'Guardar pedido'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\Pedidos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pedidos';
    }
}
