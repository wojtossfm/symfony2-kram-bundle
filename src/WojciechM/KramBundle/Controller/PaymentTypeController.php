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
class PaymentTypeController extends Controller
{

    /**
     * Lists all PaymentType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WojciechMKramBundle:PaymentType')->findAll();

        return $this->render('WojciechMKramBundle:PaymentType:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PaymentType entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PaymentType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('payment_type_show', array('id' => $entity->getId())));
        }

        return $this->render('WojciechMKramBundle:PaymentType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PaymentType entity.
     *
     * @param PaymentType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PaymentType $entity)
    {
        $form = $this->createForm(new PaymentTypeType(), $entity, array(
            'action' => $this->generateUrl('payment_type_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PaymentType entity.
     *
     */
    public function newAction()
    {
        $entity = new PaymentType();
        $form   = $this->createCreateForm($entity);

        return $this->render('WojciechMKramBundle:PaymentType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PaymentType entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:PaymentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PaymentType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:PaymentType:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PaymentType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:PaymentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PaymentType entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:PaymentType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PaymentType entity.
    *
    * @param PaymentType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PaymentType $entity)
    {
        $form = $this->createForm(new PaymentTypeType(), $entity, array(
            'action' => $this->generateUrl('payment_type_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PaymentType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:PaymentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PaymentType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('payment_type_edit', array('id' => $id)));
        }

        return $this->render('WojciechMKramBundle:PaymentType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PaymentType entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WojciechMKramBundle:PaymentType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PaymentType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('payment_type'));
    }

    /**
     * Creates a form to delete a PaymentType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('payment_type_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
