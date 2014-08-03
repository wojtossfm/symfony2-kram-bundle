<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WojciechM\KramBundle\Entity\Payment;
use WojciechM\KramBundle\Form\PaymentType;

/**
 * Payment controller.
 *
 */
class PaymentController extends Controller {
	private static $CSRF_DELETE_TOKEN = "payment_deletion_token";

    /**
     * Lists all Payment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WojciechMKramBundle:Payment')->findAll();

        return $this->render('WojciechMKramBundle:Payment:index.html.twig', array(
		'entities' => $entities,
        'delete_intention' => static::$CSRF_DELETE_TOKEN,
        ));
    }
    /**
     * Creates a new Payment entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Payment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	$week = $em->getRepository('WojciechMKramBundle:Week')->findCurrent();
			$week->addPayment($entity);
        	$entity->setWeek($week);
        	$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('payment_entry'));
        }

        return $this->render('WojciechMKramBundle:Payment:new.html.twig', array(
			'entity' => $entity,
			'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Payment entity.
     *
     * @param Payment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Payment $entity)
    {
        $form = $this->createForm(new PaymentType(), $entity, array(
		'action' => $this->generateUrl('payment_entry_create'),
		'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Payment entity.
     *
     */
    public function newAction()
    {
        $entity = new Payment();
        $form   = $this->createCreateForm($entity);

        return $this->render('WojciechMKramBundle:Payment:new.html.twig', array(
		'entity' => $entity,
		'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Payment entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Payment')->find($id);

        if (!$entity) {
		throw $this->createNotFoundException('Unable to find Payment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:Payment:edit.html.twig', array(
		'entity'      => $entity,
		'edit_form'   => $editForm->createView(),
		'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Payment entity.
    *
    * @param Payment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Payment $entity)
    {
        $form = $this->createForm(new PaymentType(), $entity, array(
		'action' => $this->generateUrl('payment_entry_update', array('id' => $entity->getId())),
		'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Payment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Payment')->find($id);

        if (!$entity) {
		throw $this->createNotFoundException('Unable to find Payment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
			$em->flush();
			return $this->redirect($this->generateUrl('payment_entry'));
        }

        return $this->render('WojciechMKramBundle:Payment:edit.html.twig', array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Payment entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
    	$csrf = $this->get('form.csrf_provider');
    	$token = $request->get("_csrf_token");
    	if ($csrf->isCsrfTokenValid(static::$CSRF_DELETE_TOKEN, $token)) {
    		$em = $this->getDoctrine()->getManager();
    		$entity = $em->getRepository('WojciechMKramBundle:Payment')->find($id);
    		
    		if (!$entity) {
    			throw $this->createNotFoundException('Unable to find Payment entity.');
    		}
    		
    		$em->remove($entity);
    		$em->flush();		
    	}
		return $this->redirect($this->generateUrl('payment_entry'));
    }
}
