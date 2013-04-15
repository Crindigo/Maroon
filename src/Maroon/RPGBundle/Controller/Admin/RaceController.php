<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Maroon\RPGBundle\Controller\MaroonController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Maroon\RPGBundle\Entity\Race;
use Maroon\RPGBundle\Form\Type\RaceType;

/**
 * Race controller.
 *
 * @Route("/admin/race")
 */
class RaceController extends MaroonController
{
    /**
     * Lists all Race entities.
     *
     * @Route("/", name="admin_race")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MaroonRPGBundle:Race')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Race entity.
     *
     * @Route("/", name="admin_race_create")
     * @Method("POST")
     * @Template("MaroonRPGBundle:Admin:Race:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $race = new Race();
        $form = $this->createForm(new RaceType(), $race);
        $form->bind($request);

        if ($form->isValid()) {
            $this->em()->persist($race);
            $this->em()->flush();

            $this->flash('success', 'Race added');
            return $this->redirect($this->generateUrl('admin_race', array('id' => $race->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Race entity.
     *
     * @Route("/new", name="admin_race_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        $entity = new Race();

        $zeros = array();
        foreach ( $statKeys as $stat ) {
            $zeros[$stat] = 0;
        }
        $entity->setStatsInit($zeros);
        $entity->setStatsBonus($zeros);

        $form   = $this->createForm(new RaceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'stats'  => $statKeys,
        );
    }

    /**
     * Displays a form to edit an existing Race entity.
     *
     * @Route("/{id}/edit", name="admin_race_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        /** @var $entity Race */
        $entity = $this->repo('Race')->find($id);

        if ( !$entity ) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $editForm = $this->createForm(new RaceType(), $entity);
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
     * @Route("/{id}", name="admin_race_update")
     * @Method("PUT")
     * @Template("MaroonRPGBundle:Admin:Race:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MaroonRPGBundle:Race')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RaceType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->flash('success', 'Race updated');
            return $this->redirect($this->generateUrl('admin_race', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Race entity.
     *
     * @Route("/{id}", name="admin_race_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MaroonRPGBundle:Race')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Race entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_race'));
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
