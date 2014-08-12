<?php

namespace WojciechM\KramBundle\Controller;
use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\Expense;
use WojciechM\KramBundle\Form\ExpenseType;

/**
 * Expense controller.
 *
 */
class ExpenseController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:Expense';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\Expense";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\ExpensePresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\ExpenseType";
	protected static $LIST_URL = 'expense';
	protected static $CREATE_URL = 'expense_create';
	protected static $UPDATE_URL = 'expense_update';

	protected function validCreatePre($entity, $em) {
		$week = $em->getRepository('WojciechMKramBundle:Week')->findCurrent();
		$week->addExpense($entity);
		$entity->setWeek($week);
	}
}
