<?php

namespace WojciechM\KramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use WojciechM\KramBundle\Form\AbstractUserType;

class UserType extends AbstractUserType
{ 
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $entity = $builder->getData();
        $isUpdate = $entity->getId() !== NULL;
        $this->addUsernameField($builder, $isUpdate);
        $this->addBasicFields($builder);
        if (!$isUpdate) {
            $this->addPasswordField($builder);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wojciechm_krambundle_user';
    }
}