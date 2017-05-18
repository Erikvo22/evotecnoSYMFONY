<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre')
        ->add('apellidos')
        ->add('email', 'email')
        ->add('dni')
        ->add('telefono')
        ->add('direccion')
        ->add('provincia')
        ->add('fnac')
        ->add('isActive', 'checkbox')
        ->add('role', 'choice', array('choices' => array( 'ROLE_USER' => 'Usuario', 'ROLE_ADMIN' => 'Administrador', 'ROLE_EMPLEADO' => 'Empleado')))
        ->add('username')
        ->add('password', 'password')
        ->add('save', 'submit', array('label' => 'Guardar usuario'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
