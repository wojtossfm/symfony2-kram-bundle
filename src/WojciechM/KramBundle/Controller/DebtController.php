<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\Debt;
use WojciechM\KramBundle\Form\DebtType;

/**
 * Debt controller.
 *
 */
class DebtController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:Debt';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\Debt";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\DebtPresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\DebtType";
	protected static $LIST_URL = 'debt';
	protected static $CREATE_URL = 'debt_create';
	protected static $UPDATE_URL = 'debt_update';

	protected function validCreatePre($entity, $em) {
		$week = $em->getRepository('WojciechMKramBundle:Week')->findCurrent();
		$week->addDebt($entity);
		$entity->setWeek($week);
	}

}
