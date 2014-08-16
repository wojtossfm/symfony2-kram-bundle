<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\ShoppingList;
use WojciechM\KramBundle\Form\ShoppingListType;

/**
 * ShoppingList controller.
 *
 */
class ShoppingListController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:ShoppingList';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\ShoppingList";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\ShoppingListPresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\ShoppingListType";
	protected static $LIST_URL = 'shoppinglist';
	protected static $CREATE_URL = 'shoppinglist_create';
	protected static $UPDATE_URL = 'shoppinglist_update';
	
	protected function validDeletePre($entity, $em) {
		$entries = $entity->getEntries();
		foreach($entries as $entry) {
			$em->remove($entry);
		}
	}
}
