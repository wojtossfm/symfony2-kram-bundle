<?php

namespace WojciechM\KramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DebtType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
//             ->add('dateCreated', null, array("widget"=>"single_text"))
            ->add('user')
            ->add('week')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WojciechM\KramBundle\Entity\Debt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wojciechm_krambundle_debt';
    }
}
