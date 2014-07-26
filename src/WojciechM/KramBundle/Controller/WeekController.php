<?php

namespace WojciechM\KramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WojciechM\KramBundle\Entity\Week;
use WojciechM\KramBundle\Form\WeekType;

/**
 * Week controller.
 *
 */
class WeekController extends Controller
{

    /**
     * Lists all Week entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WojciechMKramBundle:Week')->findAll();

        return $this->render('WojciechMKramBundle:Week:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Week entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Week();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('week_show', array('id' => $entity->getId())));
        }

        return $this->render('WojciechMKramBundle:Week:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Week entity.
     *
     * @param Week $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Week $entity)
    {
        $form = $this->createForm(new WeekType(), $entity, array(
            'action' => $this->generateUrl('week_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Week entity.
     *
     */
    public function newAction()
    {
        $entity = new Week();
        $form   = $this->createCreateForm($entity);

        return $this->render('WojciechMKramBundle:Week:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Week entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Week')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Week entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:Week:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Week entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Week')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Week entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WojciechMKramBundle:Week:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Week entity.
    *
    * @param Week $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Week $entity)
    {
        $form = $this->createForm(new WeekType(), $entity, array(
            'action' => $this->generateUrl('week_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Week entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WojciechMKramBundle:Week')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Week entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('week_edit', array('id' => $id)));
        }

        return $this->render('WojciechMKramBundle:Week:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Week entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WojciechMKramBundle:Week')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Week entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('week'));
    }

    /**
     * Creates a form to delete a Week entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('week_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
