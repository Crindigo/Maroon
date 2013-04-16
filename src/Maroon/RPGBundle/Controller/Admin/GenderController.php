<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Maroon\RPGBundle\Controller\MaroonController;
use Maroon\RPGBundle\Entity\Gender;
use Maroon\RPGBundle\Form\Type\GenderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GenderController
 *
 * @package Maroon\RPGBundle\Controller\Admin
 * @Route("/admin/gender")
 */
class GenderController extends MaroonController
{
    /**
     * Lists all Gender entities.
     *
     * @Route("/", name="admin_gender")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->repo('Gender')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Gender entity.
     *
     * @Route("/", name="admin_gender_create")
     * @Method("POST")
     * @Template("MaroonRPGBundle:Admin:Gender:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $gender = new Gender();
        $form = $this->createForm(new GenderType(), $gender);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em()->persist($gender);
            $this->em()->flush();

            $this->flash('success', 'Gender added');
            return $this->redirect($this->generateUrl('admin_gender', array('id' => $gender->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Gender entity.
     *
     * @Route("/new", name="admin_gender_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        $entity = new Gender();

        $zeros = array();
        foreach ( $statKeys as $stat ) {
            $zeros[$stat] = 0;
        }
        $entity->setStatsInit($zeros);
        $entity->setStatsBonus($zeros);

        $form   = $this->createForm(new GenderType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'stats'  => $statKeys,
        );
    }

    /**
     * Displays a form to edit an existing Gender entity.
     *
     * @Route("/{id}/edit", name="admin_gender_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        /** @var $entity Gender */
        $entity = $this->repo('Gender')->find($id);

        if ( !$entity ) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $editForm = $this->createForm(new GenderType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'stats'       => $statKeys,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Race entity.
     *
     * @Route("/{id}", name="admin_gender_update")
     * @Method("PUT")
     * @Template("MaroonRPGBundle:Admin:Gender:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->repo('Gender')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gender entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new GenderType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->flash('success', 'Gender updated');
            return $this->redirect($this->generateUrl('admin_gender', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Gender entity.
     *
     * @Route("/{id}", name="admin_gender_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->repo('Gender')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gender entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gender'));
    }

    /**
     * Creates a form to delete a Race entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }
}
