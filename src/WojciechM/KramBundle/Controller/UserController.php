<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\User;
use WojciechM\KramBundle\Form\UserType;
use WojciechM\KramBundle\Form\UserPasswordType;
use WojciechM\KramBundle\Form\Model\ChangeOwnPassword;
use WojciechM\KramBundle\Form\ChangeOwnPasswordType;

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
	
	public function changeOwnPasswordAction(Request $request) {
		$entity = new ChangeOwnPassword();
		$form = $this->createOwnChangePasswordForm($entity);
		return $this->getResponse($request, "form",
			array('entity' => $entity, 'form' => $form->createView(),)
		);
	}
	
	public function saveOwnPasswordAction(Request $request) {
		$entity = new ChangeOwnPassword();
		$form = $this->createOwnChangePasswordForm($entity);
		$form->handleRequest($request);
		$valid = $form->isValid();
		if ($valid) {
			$em = $this->getDoctrine()->getManager();
			$user = $this->getCurrentUser();
			$user->setPassword($entity->getNewPassword());
			$this->encodePassword($user);
			$em->flush();
			return $this->getResponse($request, "logout",
				null, static::$ACTION_REDIRECT);
		}
		return $this->getResponse($request, "form",
			array('entity' => $entity, 'form' => $form->createView(),)
		);
	}
	
	public function changeOtherPasswordAction(Request $request, $id) {
		$entity = $this->getEntityById($id);
		$form = $this->createOtherChangePasswordForm($entity);
		return $this->getResponse($request, "form",
			array('entity' => $entity, 'form' => $form->createView(),)
		);
	}
	
	public function saveOtherPasswordAction(Request $request, $id) {
		$entity = $this->getEntityById($id);
		$form = $this->createOtherChangePasswordForm($entity);
		$form->handleRequest($request);
		$valid = $form->isValid();
		if ($valid) {
			$em = $this->getDoctrine()->getManager();
			$this->encodePassword($entity);
			$em->flush();
			return $this->getResponse($request, static::$LIST_URL,
				null, static::$ACTION_REDIRECT);
		}
		return $this->getResponse($request, "form",
			array('entity' => $entity, 'form' => $form->createView(),)
		);
	}
	
	protected function createOwnChangePasswordForm($entity) {
		$form = $this->createForm(new ChangeOwnPasswordType(), $entity,
			array('action' => $this->generateUrl("user_save_own_password"),
				'method' => 'POST',)
		);
		$label = $this->get('translator')->trans('Change password');
		$form->add('submit', 'submit',array('label' => $label,
								'attr' => array('class' => 'button')
		));
		return $form;
	}
	
	protected function createOtherChangePasswordForm($entity) {
		$form = $this->createForm(new UserPasswordType(), $entity,
			array('action' => $this->generateUrl("user_save_other_password",
				array("id"=>$entity->getId())), 'method' => 'POST',)
		);
		$label = $this->get('translator')->trans('Change password');
		$form->add('submit', 'submit',array('label' => $label,
								'attr' => array('class' => 'button')
		));
		return $form;
	}

}
