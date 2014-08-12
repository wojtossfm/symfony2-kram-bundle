<?php

namespace WojciechM\KramBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class InvalidEntityException extends \Exception {

}

/**
 * Extended controller.
 *
 */
class ExtendedController extends Controller {
	#TODO: Move URL variables into presentation and retrieve them from there.
	protected static $ACTION_REDIRECT = "redirect";
	protected static $ENTITY = '';
	protected static $ENTITY_PRESENTATION = "";
	protected static $DEFAULT_ENTITY = 'WojciechMKramBundle:Default';
	protected static $ENTITY_CLASS = NULL;
	protected static $ENTITY_FORM = NULL;
	protected static $LIST_URL = '';
	protected static $CREATE_URL = '';
	protected static $UPDATE_URL = '';

	protected function getDeleteIntetion() {
		return get_called_class() . "_delete_token";
	}

	protected function extendContext($context) {
		$context["intention_delete"] = $this->getDeleteIntetion();
		$context["presentation"] = new static::$ENTITY_PRESENTATION();
		return $context;
	}

	protected function validCreatePre($entity, $em) {

	}

	protected function validUpdatePre($entity, $em) {

	}

	protected function getListEntities($em) {
		return $em->getRepository(static::$ENTITY)->findAll();
	}

	protected function selectTemplate(Request $request, $name) {
		$temp = $this->container->get('templating');
		$ajax = $request->isXmlHttpRequest() ? "_ajax" : "";
		$rest = $name . $ajax . '.html.twig';
		$template = static::$ENTITY . ':' . $rest;
		if ($temp->exists($template)) {
			return $template;
		}
		$template = static::$DEFAULT_ENTITY . ':' . $rest;
		return $template;
	}
	
	public static function getAjaxRedirect(Request $request, $url) {
		$response = new Response("", 200);
		$response->headers->set("X-Action", static::$ACTION_REDIRECT);
		$response->headers->set("X-Target", $url);
		return $response;
	}

	protected function getResponse(Request $request, $target, $context = null,
			$action = NULL) {
		$response = null;
		$context = ($context === null) ? array() : $context;
		switch ($action) {
		case static::$ACTION_REDIRECT: {
				$url = $this->generateUrl($target, $context);
				if ($request->isXmlHttpRequest()) {
					$response = static::getAjaxRedirect($request, $url);
				} else {
					$response = $this->redirect($url);
				}
				break;
			}
		default: {
				$template = $this->selectTemplate($request, $target);
				$response = $this->render($template, $this->extendContext($context));
			}
		}
		return $response;
	}

	/**
	 * Lists all entities.
	 *
	 */
	public function indexAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$entities = $this->getListEntities($em);
		return $this
				->getResponse($request, "index",
						array('entities' => $entities));
	}

	/**
	 * Creates a new entity.
	 *
	 */
	public function createAction(Request $request) {
		$entity = new static::$ENTITY_CLASS();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);
		$valid = $form->isValid();
		if ($valid) {
			$em = $this->getDoctrine()->getManager();
			$this->validCreatePre($entity, $em);
			$em->persist($entity);
			$em->flush();
			return $this
					->getResponse($request, static::$LIST_URL, null,
							static::$ACTION_REDIRECT);
		}
		return $this
				->getResponse($request, "new",
						array('entity' => $entity,
								'form' => $form->createView(),));
	}

	/**
	 * Displays a form to create a new entity.
	 *
	 */
	public function newAction(Request $request) {
		$entity = new static::$ENTITY_CLASS();
		$form = $this->createCreateForm($entity);
		return $this
				->getResponse($request, "new",
						array('entity' => $entity,
								'form' => $form->createView(),));
	}

	/**
	 * Finds and displays an entity.
	 *
	 */
	public function showAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository(static::$ENTITY)->find($id);
		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find ' . static::$ENTITY . ' entity.');
		}
		return $this
				->getResponse($request, "show",
						array('entity' => $entity,));
	}

	/**
	 * Displays a form to edit an existing entity.
	 *
	 */
	public function editAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository(static::$ENTITY)->find($id);

		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find ' . static::$ENTITY . ' entity.');
		}

		$editForm = $this->createEditForm($entity);
		return $this
				->getResponse($request, "edit",
						array('entity' => $entity,
								'edit_form' => $editForm->createView(),));
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
			return $this
					->getResponse($request, static::$LIST_URL, array(),
							static::$ACTION_REDIRECT);
		}
		return $this
				->getResponse($request, "edit",
						array('entity' => $entity,
								'edit_form' => $editForm->createView()));
	}

	/**
	 * Deletes an entity.
	 */
	public function deleteAction(Request $request, $id) {
		$csrf = $this->get('form.csrf_provider');
		$token = $request->get("_csrf_token");
		if ($csrf->isCsrfTokenValid($this->getDeleteIntetion(), $token)) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository(static::$ENTITY)->find($id);

			if (!$entity) {
				throw $this
						->createNotFoundException(
								'Unable to find ' . static::$ENTITY
										. ' entity.');
			}

			$em->remove($entity);
			$em->flush();
		}
		return $this
				->getResponse($request, static::$LIST_URL, null,
						static::$ACTION_REDIRECT);
	}

	/**
	 * Creates a form to create an entity.
	 *
	 * @param $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	protected function createCreateForm($entity) {
		if (!$entity instanceof static::$ENTITY_CLASS) {
			throw new InvalidEntityException();
		}
		$form = $this
				->createForm(new static::$ENTITY_FORM(), $entity,
						array(
								'action' => $this
										->generateUrl(static::$CREATE_URL),
								'method' => 'POST',));
		$label = $this->get('translator')->trans('Create');
		$form
				->add('submit', 'submit',
						array('label' => $label,
								'attr' => array('class' => 'button')));

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
		if (!$entity instanceof static::$ENTITY_CLASS) {
			throw new InvalidEntityException();
		}
		$form = $this
				->createForm(new static::$ENTITY_FORM(), $entity,
						array(
								'action' => $this
										->generateUrl(static::$UPDATE_URL,
												array('id' => $entity->getId())),
								'method' => 'PUT',));
		$label = $this->get('translator')->trans('Update');
		$form
				->add('submit', 'submit',
						array('label' => $label,
								'attr' => array('class' => 'button')));

		return $form;
	}
}
