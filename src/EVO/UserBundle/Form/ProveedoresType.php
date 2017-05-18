<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class ProveedoresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empresa')
            ->add('cial')
            ->add('direccion')
            ->add('telefono')
            ->add('email')
            ->add('descripcion')
            
       
            ->add('save', 'submit', array('label' => 'Guardar tarea'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\Proveedores'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'proveedores';
    }
}
