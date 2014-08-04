<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WojciechM\KramBundle\Entity\PaymentType;
use WojciechM\KramBundle\Form\PaymentTypeType;

/**
 * PaymentType controller.
 *
 */
class PaymentTypeController extends Controller {
	protected static $ENTITY = 'WojciechMKramBundle:PaymentType';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\PaymentType";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\PaymentTypeType";
	protected static $LIST_URL = 'payment_type';
	protected static $CREATE_URL = 'payment_type_create';
	protected static $UPDATE_URL = 'payment_type_update';

}
