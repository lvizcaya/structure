<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     * @Security("has_role('ROLE_USERS_MENU')")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.user');
        $datatable->buildDatatable();
        return $this->render('user/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="user_results")
     */
    public function indexResultsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $datatable = $this->get('app.datatable.user');
        $datatable->buildDatatable();
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);
        $function = function($qb)
        {
            $qb->andWhere("structure_user.emailCanonical != 'admin@gmail.com'");
        };
        $query->addWhereAll($function);
        return $query->getResponse();
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USERS_ADD')")
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush($user);
            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }
        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show", options={"expose"=true})
     * @Method("GET")
     * @Security("has_role('ROLE_USERS_SHOW')")
     */
    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USERS_EDIT')")
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserEditType', $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USERS_DELETE')")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
