<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\Payment;
use WojciechM\KramBundle\Entity\Expense;
use WojciechM\KramBundle\Entity\PaymentType as PT;
use WojciechM\KramBundle\Form\PaymentType;

/**
 * Payment controller.
 *
 */
class PaymentController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:Payment';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\Payment";
	protected static $ENTITY_PRESENTATION = "WojciechM\KramBundle\Presentation\PaymentPresentation";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\PaymentType";
	protected static $LIST_URL = 'payment';
	protected static $CREATE_URL = 'payment_create';
	protected static $UPDATE_URL = 'payment_update';
	
	protected function validCreatePre($entity, $em) {
		$week = $em->getRepository('WojciechMKramBundle:Week')->findCurrent();
		$week->addPayment($entity);
		$entity->setWeek($week);
		$type = $entity->getType();
		if (strcmp($type->getName(), PT::TYPE_EXPENSE) == 0) {
			$exp = new Expense();
			$exp->setWeek($week);
			$exp->setAmount($entity->getAmount());
			$exp->setComment($entity->getUser());
			$em->persist($exp);
		}
	}
}
