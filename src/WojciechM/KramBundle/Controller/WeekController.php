<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use WojciechM\KramBundle\Controller\ExtendedController;
use WojciechM\KramBundle\Entity\Week;
use WojciechM\KramBundle\Form\WeekType;

/**
 * Week controller.
 *
 */
class WeekController extends ExtendedController {
	protected static $ENTITY = 'WojciechMKramBundle:Week';
	protected static $ENTITY_CLASS = "WojciechM\KramBundle\Entity\Week";
	protected static $ENTITY_FORM = "WojciechM\KramBundle\Form\WeekType";
	protected static $LIST_URL = 'week';
	protected static $CREATE_URL = 'week_create';
	protected static $UPDATE_URL = 'week_update';

    /**
     * Lists all Week entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $weeks = $em->getRepository(static::$ENTITY)->findAllWithJoins();
        return $this->render(static::$ENTITY.':index.html.twig', array(
            'entities' => $weeks,
        ));
    }
    
    protected function validUpdatePre($entity, $em) {
        	$debts = $entity->getDebts();
        	$fee = $entity->getFee();
        	foreach($debts as $debt) {
        		$debt->setAmount($fee);
        	}
	}
}
