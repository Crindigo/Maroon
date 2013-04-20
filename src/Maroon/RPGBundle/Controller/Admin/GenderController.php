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
     * @Template
     */
    public function indexAction()
    {
        $entities = $this->repo('Gender')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Gender entity.
     *
     * @Route("/new", name="admin_gender_new")
     * @Template
     */
    public function newAction(Request $request)
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        $entity = new Gender();

        if ( $request->isMethod('GET') ) {
            $zeros = array();
            foreach ( $statKeys as $stat ) {
                $zeros[$stat] = 0;
            }
            $entity->setStatsInit($zeros);
            $entity->setStatsBonus($zeros);
        }

        $form = $this->createForm(new GenderType(), $entity);

        if ( $request->isMethod('POST') ) {
            $form->bind($request);
            if ( $form->isValid() ) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Gender added');
                return $this->redirect($this->generateUrl('admin_gender', ['id' => $entity->getId()]));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Gender entity.
     *
     * @Route("/{id}/edit", name="admin_gender_edit")
     * @Template
     */
    public function editAction(Request $request, $id)
    {
        /** @var $entity Gender */
        $entity = $this->repo('Gender')->find($id);

        if ( !$entity ) {
            throw $this->createNotFoundException('Unable to find Gender entity.');
        }

        $editForm = $this->createForm(new GenderType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        if ( $request->isMethod('POST') ) {
            $editForm->bind($request);

            if ( $editForm->isValid() ) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Gender updated');
                return $this->redirect($this->generateUrl('admin_gender', ['id' => $id]));
            }
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
     * Creates a form to delete a Gender entity by id.
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
