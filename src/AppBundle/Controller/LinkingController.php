<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Linking;
use AppBundle\Form\LinkingType;

/**
 * Linking controller.
 *
 * @Route("/linking")
 */
class LinkingController extends Controller
{
    /**
     * Lists all Linking entities.
     *
     * @Route("/", name="linking_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $linkings = $em->getRepository('AppBundle:Linking')->findAll();

        return $this->render('linking/index.html.twig', array(
            'linkings' => $linkings,
        ));
    }

    /**
     * Creates a new Linking entity.
     *
     * @Route("/new", name="linking_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $linking = new Linking();
        $form = $this->createForm('AppBundle\Form\LinkingType', $linking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($linking);
            $em->flush();

            return $this->redirectToRoute('linking_show', array('id' => $linking->getId()));
        }

        return $this->render('linking/new.html.twig', array(
            'linking' => $linking,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Linking entity.
     *
     * @Route("/{id}", name="linking_show")
     * @Method("GET")
     */
    public function showAction(Linking $linking)
    {
        $deleteForm = $this->createDeleteForm($linking);

        return $this->render('linking/show.html.twig', array(
            'linking' => $linking,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Linking entity.
     *
     * @Route("/{id}/edit", name="linking_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Linking $linking)
    {
        $deleteForm = $this->createDeleteForm($linking);
        $editForm = $this->createForm('AppBundle\Form\LinkingType', $linking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($linking);
            $em->flush();

            return $this->redirectToRoute('linking_edit', array('id' => $linking->getId()));
        }

        return $this->render('linking/edit.html.twig', array(
            'linking' => $linking,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Linking entity.
     *
     * @Route("/{id}", name="linking_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Linking $linking)
    {
        $form = $this->createDeleteForm($linking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($linking);
            $em->flush();
        }

        return $this->redirectToRoute('linking_index');
    }

    /**
     * Creates a form to delete a Linking entity.
     *
     * @param Linking $linking The Linking entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Linking $linking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linking_delete', array('id' => $linking->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
