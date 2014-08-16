<?php

namespace WojciechM\KramBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShoppingListType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		//$builder->add('dateCreated');
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver
				->setDefaults(
						array(
								'data_class' => 'WojciechM\KramBundle\Entity\ShoppingList'));
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'wojciechm_krambundle_shoppinglist';
	}
}
