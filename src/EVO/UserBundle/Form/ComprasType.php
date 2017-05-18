<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class ComprasType extends AbstractType
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
        
        ->add('user', 'entity', array(
        		'class' => 'EVOUserBundle:User',
        		'query_builder' => function (EntityRepository $er) {
        		return $er ->createQueryBuilder('u')
        		->where('u.role = :only')
        		-> setParameter('only', 'ROLE_USER');
        		},
        		 
        		'choice_label' => 'getFullName'
        ))
        
        ->add('fechacomp')
        ->add('cantidad')
        ->add('preciototal')
        ->add('direccion')
         
        ->add('save', 'submit', array('label' => 'Guardar venta'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\Compras'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'compras';
    }
}
