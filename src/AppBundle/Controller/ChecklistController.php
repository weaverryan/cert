<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Checklist;
use AppBundle\Form\ChecklistType;

/**
 * Checklist controller.
 *
 * @Route("/checklist")
 */
class ChecklistController extends Controller
{


    /**
     * Creates a new Checklist entity.
     *
     * @Route("/", name="checklist_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Checklist();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $entity->setUser($user);

            $user_entity = $em->getRepository('AppBundle:User')->find($user);
            $status = $em->getRepository('AppBundle:Status')->findByName('Checklist Created');
            $user_entity->setProgress($status);

            $em->persist($entity);
            $em->persist($user_entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Checklist entity.
     *
     * @param Checklist $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Checklist $entity)
    {
        $form = $this->createForm(new ChecklistType(), $entity, array(
            'action' => $this->generateUrl('checklist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Checklist entity.
     *
     * @Route("/new", name="checklist_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Checklist();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Checklist entity.
     *
     * @Route("/{id}/edit", name="checklist_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Checklist entity.
    *
    * @param Checklist $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Checklist $entity)
    {
        $form = $this->createForm(new ChecklistType(), $entity, array(
            'action' => $this->generateUrl('checklist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Checklist entity.
     *
     * @Route("/{id}", name="checklist_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Checklist entity.
     *
     * @Route("/{id}", name="checklist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Checklist')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Checklist entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile'));
    }

    /**
     * Creates a form to delete a Checklist entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('checklist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
