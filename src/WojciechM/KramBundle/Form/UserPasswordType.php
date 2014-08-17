<?php

namespace WojciechM\KramBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use WojciechM\KramBundle\Form\AbstractUserType;

class UserPasswordType extends AbstractUserType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->addUsernameField($builder, True);
        $this->addPasswordField($builder);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wojciechm_krambundle_user_password';
    }
}
