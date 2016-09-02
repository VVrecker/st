<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        // replace this example code with whatever you need
        // return $this->render('default/index.html.twig', [
        // 'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..')
        // ]);
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->findAll();
        $goods = $em->getRepository('AppBundle:Goods')->findAll();
        $linking = $em->getRepository('AppBundle:Linking')->findAll();
        return $this->render('default/index.html.twig', array(
            'categories' => $categories,
            'goods' => $goods,
            'linking' => $linking
        ));
        
        // return $this->render('Default/category.html.twig', array(
        // 'name' => '111'
        // ));
    }

    /**
     * @Route("/{name}", name="category_name")
     */
    public function category_name($name)
    {
       
        $em = $this->getDoctrine()->getManager();
       // $qb = $em->createQueryBuilder();
        $query = $em->createQuery('
            SELECT 
                g.name 
            FROM 
                AppBundle:Goods g,
                AppBundle:Categories c,
                AppBundle:Linking l
            WHERE 
                g.id = l.goods AND
                l.categories = c.id AND
                c.name LIKE :name
            GROUP BY 
                g.id
            ORDER BY
                g.name');
        $query->setParameter('name', $name);
       // $goods=$query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY) ;
        $goods=$query->getResult() ;
        $categories = $em->getRepository('AppBundle:Categories')->findOneBy(array('name'=>$name));
        $linking = $em->getRepository('AppBundle:Linking')->findBy(['categories'=>$categories->getId()]);
        //var_dump($linking);
        return $this->render('default/category.html.twig', array(
            'name' => $name, 'goods'=>$goods
        ));
    }
   
}
