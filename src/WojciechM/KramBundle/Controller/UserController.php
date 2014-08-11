<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\User;
use WojciechM\KramBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:User';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\User";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\UserPresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\UserType";
	protected static $LIST_URL = 'user';
	protected static $CREATE_URL = 'user_create';
	protected static $UPDATE_URL = 'user_update';
	
	protected function encodePassword(User $user) {
		$factory = $this->container->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user);
		$user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
	}
	
	protected function validCreatePre($entity, $em) {
		$this->encodePassword($entity);
	}
	
	protected function validUpdatePre($entity, $em) {
		$this->encodePassword($entity);
	}


}
