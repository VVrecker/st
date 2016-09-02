<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Goods;
use AppBundle\Form\GoodsType;

/**
 * Goods controller.
 *
 * @Route("/goods")
 */
class GoodsController extends Controller
{
    /**
     * Lists all Goods entities.
     *
     * @Route("/", name="goods_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $goods = $em->getRepository('AppBundle:Goods')->findAll();

        return $this->render('goods/index.html.twig', array(
            'goods' => $goods,
        ));
    }

    /**
     * Creates a new Goods entity.
     *
     * @Route("/new", name="goods_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $good = new Goods();
        $form = $this->createForm('AppBundle\Form\GoodsType', $good);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($good);
            $em->flush();

            return $this->redirectToRoute('goods_show', array('id' => $good->getId()));
        }

        return $this->render('goods/new.html.twig', array(
            'good' => $good,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Goods entity.
     *
     * @Route("/{id}", name="goods_show")
     * @Method("GET")
     */
    public function showAction(Goods $good)
    {
        $deleteForm = $this->createDeleteForm($good);

        return $this->render('goods/show.html.twig', array(
            'good' => $good,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Goods entity.
     *
     * @Route("/{id}/edit", name="goods_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Goods $good)
    {
        $deleteForm = $this->createDeleteForm($good);
        $editForm = $this->createForm('AppBundle\Form\GoodsType', $good);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($good);
            $em->flush();

            return $this->redirectToRoute('goods_edit', array('id' => $good->getId()));
        }

        return $this->render('goods/edit.html.twig', array(
            'good' => $good,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Goods entity.
     *
     * @Route("/{id}", name="goods_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Goods $good)
    {
        $form = $this->createDeleteForm($good);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($good);
            $em->flush();
        }

        return $this->redirectToRoute('goods_index');
    }

    /**
     * Creates a form to delete a Goods entity.
     *
     * @param Goods $good The Goods entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Goods $good)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('goods_delete', array('id' => $good->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
