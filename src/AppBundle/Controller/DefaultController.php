<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->findAll();
        $goods = $em->getRepository('AppBundle:Goods')->findAll();
        return $this->render('default/index.html.twig', array(
            'categories' => $categories,
            'goods' => $goods,
        ));
    }

    /**
     * @Route("/{name}", name="category_name")
     */
    public function category_name($name)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Categories')->findOneBy(array('name'=>$name));
        return $this->render('default/category.html.twig', array(
            'name' => $name, 'category'=>$category
        ));
    }
   
}
