<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WojciechM\KramBundle\Entity\Debt;
use WojciechM\KramBundle\Form\DebtType;

/**
 * Debt controller.
 *
 */
class DebtController extends Controller
{

    /**
     * Lists all Debt entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WojciechMKramBundle:Debt')->findAll();

        return $this->render('WojciechMKramBundle:Debt:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Debt entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Debt();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('debt_show', array('id' => $entity->getId())));
        }

        return $this->render('WojciechMKramBundle:Debt:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Debt entity.
     *
     * @param Debt $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Debt $entity)
    {
        $form = $this->createForm(new DebtType(), $entity, array(
            'action' => $this->generateUrl('debt_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Debt entity.
     *
     */
    public function newAction()
    {
        $entity = new Debt();
        $form   = $this->createCreateForm($entity);

        return $this->render('WojciechMKramBundle:Debt:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Debt entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Debt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Debt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:Debt:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Debt entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Debt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Debt entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:Debt:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Debt entity.
    *
    * @param Debt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Debt $entity)
    {
        $form = $this->createForm(new DebtType(), $entity, array(
            'action' => $this->generateUrl('debt_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Debt entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Debt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Debt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('debt_edit', array('id' => $id)));
        }

        return $this->render('WojciechMKramBundle:Debt:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Debt entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WojciechMKramBundle:Debt')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Debt entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('debt'));
    }

    /**
     * Creates a form to delete a Debt entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('debt_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
