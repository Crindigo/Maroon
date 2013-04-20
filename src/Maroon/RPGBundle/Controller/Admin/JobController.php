<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Maroon\RPGBundle\Controller\MaroonController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Maroon\RPGBundle\Entity\Job;
use Maroon\RPGBundle\Form\Type\JobType;

/**
 * @Route("/admin/job")
 */
class JobController extends MaroonController
{
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="admin_job")
     * @Method("GET")
     * @Template
     */
    public function indexAction()
    {
        $entities = $this->repo('Job')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="admin_job_new")
     * @Template
     */
    public function newAction(Request $request)
    {
        $statKeys = array_keys($this->container->getParameter('maroon_rpg.base_stats'));

        $entity = new Job();

        if ( $request->isMethod('GET') ) {
            $zeros = array();
            foreach ( $statKeys as $stat ) {
                $zeros[$stat] = 0;
            }
            $entity->setStatsInit($zeros);
            $entity->setStatsBonus($zeros);
        }

        $form = $this->createForm(new JobType(), $entity);

        if ( $request->isMethod('POST') ) {
            $form->bind($request);
            if ( $form->isValid() ) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Job added');
                return $this->redirect($this->generateUrl('admin_job', ['id' => $entity->getId()]));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="admin_job_edit")
     * @Template
     */
    public function editAction(Request $request, $id)
    {
        /** @var $entity Job */
        $entity = $this->repo('Job')->find($id);

        if ( !$entity ) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $editForm = $this->createForm(new JobType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        if ( $request->isMethod('POST') ) {
            $editForm->bind($request);

            if ( $editForm->isValid() ) {
                $this->em()->persist($entity);
                $this->em()->flush();

                $this->flash('success', 'Job updated');
                return $this->redirect($this->generateUrl('admin_job', ['id' => $id]));
            }
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}", name="admin_job_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->repo('Job')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_job'));
    }

    /**
     * Creates a form to delete a Job entity by id.
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
