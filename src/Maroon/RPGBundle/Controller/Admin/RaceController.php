<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Maroon\RPGBundle\Controller\MaroonController;
use Symfony\Component\HttpFoundation\Request;
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
     * Displays a form to create a new Race entity.
     *
     * @Route("/new", name="admin_race_new")
     * @Template
     */
    public function newAction(Request $request)
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        $entity = new Race();
        if ( $request->isMethod('GET') ) {
            $zeros = array();
            foreach ( $statKeys as $stat ) {
                $zeros[$stat] = 0;
            }
            $entity->setStatsInit($zeros);
            $entity->setStatsBonus($zeros);
        }

        $form = $this->createForm(new RaceType(), $entity);

        if ( $request->isMethod('POST') ) {
            $form->bind($request);

            if ($form->isValid()) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Race added');
                return $this->redirect($this->generateUrl('admin_race', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Race entity.
     *
     * @Route("/{id}/edit", name="admin_race_edit")
     * @Template
     */
    public function editAction(Request $request, $id)
    {
        /** @var $entity Race */
        $entity = $this->repo('Race')->find($id);

        if ( !$entity ) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $editForm = $this->createForm(new RaceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        if ( $request->isMethod('POST') ) {
            $editForm->bind($request);

            if ( $editForm->isValid() ) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Race updated');
                return $this->redirect($this->generateUrl('admin_race', ['id' => $id]));
            }
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
