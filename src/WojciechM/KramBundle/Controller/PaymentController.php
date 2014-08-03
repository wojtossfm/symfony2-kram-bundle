<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\Payment;
use WojciechM\KramBundle\Form\PaymentType;

/**
 * Payment controller.
 *
 */
class PaymentController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:Payment';
	protected static $ENTITY_CLASS = "Payment";
	protected static $ENTITY_FORM = "PaymentType";
	protected static $LIST_URL = 'payment_entry';
	protected static $CREATE_URL = 'payment_create';
	protected static $UPDATE_URL = 'payment_update';
	
	protected function validCreatePre($entity, $em) {
		$week = $em->getRepository('WojciechMKramBundle:Week')->findCurrent();
		$week->addPayment($entity);
		$entity->setWeek($week);
	}
}
