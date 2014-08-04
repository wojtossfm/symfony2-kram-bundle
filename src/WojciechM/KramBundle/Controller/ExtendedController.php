<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvalidEntityException extends \Exception {
	
}

/**
 * Extended controller.
 *
 */
class ExtendedController extends Controller {
	protected static $ENTITY = '';
	protected static $DEFAULT_ENTITY = 'WojciechMKramBundle:Default';
	protected static $ENTITY_CLASS = NULL;
	protected static $ENTITY_FORM = NULL;
	protected static $LIST_URL = '';
	protected static $CREATE_URL = '';
	protected static $UPDATE_URL = '';
	
	protected function getDeleteIntetion() {
		return get_called_class(). "_delete_token";
	}

	protected function extendContext($context) {
		$context["intention_delete"] = $this->getDeleteIntetion();
		return $context;
	}
	
	protected function validCreatePre($entity, $em) {
		
	}
	
	protected function validUpdatePre($entity, $em) {
		
	}
	
	protected function selectTemplate(Request $request, $name) {
		$temp = $this->container->get('templating');
		$ajax = $request->isXmlHttpRequest() ? "_ajax" : "";
		$rest = $name.$ajax.'.html.twig';
		$template = static::$ENTITY.':'.$rest;
		if ($temp->exists($template)) {
			return $template;
		}
		$template = static::$DEFAULT_ENTITY.':'.$rest;
		return $template;
	}
	

	/**
	 * Lists all entities.
	 *
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository(static::$ENTITY)->findAll();
		return $this->render(static::$ENTITY.':index.html.twig', $this->extendContext(array(
				'entities' => $entities
		)));
	}
	
	/**
	 * Creates a new entity.
	 *
	 */
	public function createAction(Request $request)
	{
		$entity = new static::$ENTITY_CLASS();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$this->validCreatePre($entity, $em);
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl(static::$LIST_URL));
		}
	
		return $this->render($this->selectTemplate($request, "new"), array(
				'entity' => $entity,
				'form'   => $form->createView(),
		));
	}
	
	/**
	 * Displays a form to create a new entity.
	 *
	 */
	public function newAction(Request $request)
	{
		$entity = new static::$ENTITY_CLASS();
		$form   = $this->createCreateForm($entity);
	
		return $this->render($this->selectTemplate($request, "new"), array(
				'entity' => $entity,
				'form'   => $form->createView(),
		));
	}
	
	/**
	 * Finds and displays an entity.
	 *
	 */
	public function showAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository(static::$ENTITY)->find($id);
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find '.static::$ENTITY.' entity.');
		}
		return $this->render($this->selectTemplate($request, "show"), array(
			'entity' => $entity,
		));
	}
	
	/**
	 * Displays a form to edit an existing entity.
	 *
	 */
	public function editAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
	
		$entity = $em->getRepository(static::$ENTITY)->find($id);
	
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find '.static::$ENTITY.' entity.');
		}
	
		$editForm = $this->createEditForm($entity);
		return $this->render($this->selectTemplate($request, "edit"), array(
				'entity'	  => $entity,
				'edit_form'   => $editForm->createView(),
		));
	}
	
	public function updateAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
	
		$entity = $em->getRepository(static::$ENTITY)->find($id);
	
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find entity.');
		}
	
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);
	
		if ($editForm->isValid()) {
			$this->validUpdatePre($entity, $em);
			$em->flush();
			return $this->redirect($this->generateUrl(static::$LIST_URL));
		}
	
		return $this->render($this->selectTemplate($request, "edit"), $this->extendContext(array(
				'entity'	  => $entity,
				'edit_form'   => $editForm->createView()
		)));
	}

	/**
	 * Deletes an entity.
	 */
	public function deleteAction(Request $request, $id)
	{
		$csrf = $this->get('form.csrf_provider');
		$token = $request->get("_csrf_token");
		if ($csrf->isCsrfTokenValid($this->getDeleteIntetion(), $token)) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository(static::$ENTITY)->find($id);
		
			if (!$entity) {
				throw $this->createNotFoundException('Unable to find '.static::$ENTITY.' entity.');
			}
		
			$em->remove($entity);
			$em->flush();
		}
		return $this->redirect($this->generateUrl(static::$LIST_URL));
	}


	/**
	 * Creates a form to create an entity.
	 *
	 * @param $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	protected function createCreateForm($entity) {
		if (! $entity instanceof static::$ENTITY_CLASS) {
			throw new InvalidEntityException();
		}
		$form = $this->createForm(new static::$ENTITY_FORM(), $entity, array(
				'action' => $this->generateUrl(static::$CREATE_URL),
				'method' => 'POST',
		));
	
		$form->add('submit', 'submit', array('label' => 'Create'));
	
		return $form;
	}
	
	/**
	 * Creates a form to edit an entity.
	 *
	 * @param $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	protected function createEditForm($entity) {
		if (! $entity instanceof static::$ENTITY_CLASS) {
			throw new InvalidEntityException();
		}
		$form = $this->createForm(new static::$ENTITY_FORM(), $entity, array(
				'action' => $this->generateUrl(static::$UPDATE_URL, array('id' => $entity->getId())),
				'method' => 'PUT',
		));
	
		$form->add('submit', 'submit', array('label' => 'Update'));
	
		return $form;
	}
}
