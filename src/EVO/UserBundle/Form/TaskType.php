<?php

namespace EVO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('user', 'entity', array(
            	'class' => 'EVOUserBundle:User',
            	'query_builder' => function (EntityRepository $er) {
            		return $er ->createQueryBuilder('u')
            		->where('u.role = :only')
            		-> setParameter('only', 'ROLE_EMPLEADO');
            	},
            	
            	'choice_label' => 'getFullName'
            ))
            
       
            ->add('save', 'submit', array('label' => 'Guardar tarea'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EVO\UserBundle\Entity\Task'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'task';
    }
}
