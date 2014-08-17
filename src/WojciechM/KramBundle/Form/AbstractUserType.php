<?php
namespace WojciechM\KramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractUserType extends AbstractType {
    
    protected function addUsernameField(FormBuilderInterface $builder, $readonly=False) {
        $builder->add('username', NULL, array("read_only"=>$readonly));
    }
    
    protected function addPasswordField(FormBuilderInterface $builder) {
        $builder
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
        ));
    }
    
    protected function addBasicFields(FormBuilderInterface $builder) {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('active', NULL, array("required"=>False))
            ->add('admin', NULL, array("required"=>False))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WojciechM\KramBundle\Entity\User'
        ));
    }
}