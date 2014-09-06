<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\ShoppingListEntry;
use WojciechM\KramBundle\Entity\Expense;
use WojciechM\KramBundle\Entity\ShoppingList;
use WojciechM\KramBundle\Entity\Week;
use WojciechM\KramBundle\Form\ExpenseType;

class ShoppingListEntryController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:ShoppingListEntry';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\ShoppingListEntry";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\ShoppingListEntryPresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\ShoppingListEntryType";
	protected static $LIST_URL = 'shopping_widget';
	protected static $CREATE_URL = 'shopping_widget_entry';
	protected static $UPDATE_URL = 'shoppinglist_update';
	protected static $ACTION_WIDGET = "widget";

	protected function getCurrentList($em) {
		return $em->getRepository("WojciechMKramBundle:ShoppingList")->findCurrent();
	}
	
	protected function getListEntities($em) {
		$shoppingList = $this->getCurrentList($em);
		return $shoppingList->getEntries();
	}
	
	protected function getVoteIntention() {
		return "shopping_entry_vote_token";
	}
	
	protected function extendContext($context) {
		$context = parent::extendContext($context);
		$em = $this->getDoctrine()->getManager();
		$week = $em->getRepository("WojciechMKramBundle:Week")->findCurrent();
		$context["entities"] = $this->getListEntities($em);
		$context["intention_vote"] = $this->getVoteIntention();
		$context["shoppers"] = $week->getShoppers();
		return $context;
	}
	
	protected function validCreatePre($entity, $em) {
		$user = $this->getCurrentUser();
		$entity->setUser($user);
		$shoppingList = $this->getCurrentList($em);
		$entity->setList($shoppingList);
	}
	
	protected function getResponse(Request $request, $target, $context = null,
			$action = NULL) {
		$response = null;
		$context = ($context === null) ? array() : $context;
		switch ($action) {
			case static::$ACTION_REDIRECT: {
				$url = $this->generateUrl($target, $context);
				$response = $this->redirect($url);
				break;
			}
			case static::$ACTION_WIDGET: {
				$url = $this->generateUrl($target, $context);
				$response = static::getAjaxRedirect($request, $url, $action);
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
	 * Votes for an entity.
	 */
	public function voteAction(Request $request, $id) {
		$csrf = $this->get('form.csrf_provider');
		$token = $request->get("_csrf_token");
		if ($csrf->isCsrfTokenValid($this->getVoteIntention(), $token)) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository(static::$ENTITY)->find($id);

			if (!$entity) {
				throw $this->createNotFoundException(
					'Unable to find ' . static::$ENTITY. ' entity.'
				);
			}
			/* @param $entity ShoppingListEntry */
			$entity->addVoter($this->getCurrentUser());
			$em->flush();
		} else {
			throw new \Exception("Invalid CSRF token");
		}
		return $this
				->getResponse($request, static::$LIST_URL, null,
						static::$ACTION_REDIRECT);
	}
	
	/**
	 * Displays a form to create a new entity.
	 *
	 */
	public function reportAction(Request $request) {
		$entity = new Expense();
		$list = $this->getCurrentList($this->getDoctrine()->getManager());
		$week = $this->getCurrentWeek();
		$comment = $this->get('translator')->trans('Closing list from ');
		$comment .= $list;
		$entity->setComment($comment);
		$entity->setWeek($week);
		$form = $this->createCloseForm($entity);
		$entries = $list->getEntries();
		if ($entries->count() == 0) {
			return $this->getResponse($request, static::$LIST_URL, NULL, static::$ACTION_WIDGET);
		}
		
		return $this
			->getResponse($request, "close",
				array('entity' => $entity,
				'form' => $form->createView(),));
	}
	
	/**
	 * Closes the current shopping list.
	 *
	 */
	public function closeAction(Request $request) {
		$entity = new Expense();
		$form = $this->createCloseForm($entity);
		$form->handleRequest($request);
		$valid = $form->isValid();
		$em = $this->getDoctrine()->getManager();
		$list = $this->getCurrentList($em);
		if (! $list->getEntries()) {
			return $this->getResponse($request, static::$LIST_URL, NULL, static::$ACTION_WIDGET);
		}
		
		if ($valid) {
			$em->persist($entity);
			$em->persist(new ShoppingList());
			$em->flush();
			return $this
					->getResponse($request, static::$LIST_URL, null,
							static::$ACTION_WIDGET);
		}
		return $this
				->getResponse($request, "close",
						array('entity' => $entity,
								'form' => $form->createView(),));
	}
		
	protected function createCloseForm(Expense $entity) {
		$form = $this->createForm(new ExpenseType(), $entity,
			array('action' => $this->generateUrl("shopping_widget_close"),
				'method' => 'POST',));
		$label = $this->get('translator')->trans('Submit report');
		$form
				->add('submit', 'submit',
						array('label' => $label,
					'attr' => array('class' => 'button')));
		return $form;
	}
}
