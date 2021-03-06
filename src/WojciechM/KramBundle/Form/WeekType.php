<?php

namespace WojciechM\KramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeekType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'date')
            ->add('end', 'date')
            ->add('fee')
            ->add('collectors', null, array('required'=> False))
            ->add('shoppers', null, array('required'=> False))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WojciechM\KramBundle\Entity\Week'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wojciechm_krambundle_week';
    }
}
