<?php

namespace Garak\DemoBundle\Controller;

use Garak\DemoBundle\Entity\Product;
use Garak\DemoBundle\Form\Type\FilterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Homepage: show products
     *
     * @Route("/", name="homepage")
     * @Template
     */
    public function indexAction()
    {
        $sessionCart = $this->get('garak_demo.cart');
        $filters = $sessionCart->getFilters($this->getDoctrine()->getEntityManager());
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->search($filters);
        $form = $this->createForm(new FilterType, $filters);
        
        return array('products' => $products, 'form' => $form->createView());
    }

    /**
     * Filter products
     *
     * @Route("/filter", name="filter")
     * @Template("GarakDemoBundle:Default:index.html.twig")
     */
    public function filterAction()
    {
        $sessionCart = $this->get('garak_demo.cart');
        $filters = $sessionCart->getFilters($this->getDoctrine()->getEntityManager());
        $form = $this->createForm(new FilterType, $filters);
        $request = $this->getRequest();
        $form->bindRequest($request);
        if ($form->isValid()) {
            $sessionCart->setFilters($form->getData(), $this->getDoctrine()->getEntityManager());
        }
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->search($filters);

        if (!$this->getRequest()->isXmlHttpRequest()) {
            return array('products' => $products, 'form' => $form->createView());
        } else {
            $content = $this->renderView('GarakDemoBundle:Default:filter.json.twig', compact('products'));
            $response = new Response($content);
            $response->headers->set('Content-Type', 'application/json');
            
            return $response;
        }
    }
    
    /**
     * The cart box
     *
     * @Route("/cart", name="cart")
     * @Template
     */
    public function cartAction()
    {       
        $sessionCart = $this->get('garak_demo.cart');
        $cart = $sessionCart->get();
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->findByIds(array_keys($cart));
        $total = $sessionCart->getTotal($products);

        return compact('cart', 'products', 'total');
    }
    
    /**
     * Add product to cart
     *
     * @Route("/{slug}/add", name="add", defaults={"_format"="json"})
     * @Template
     */
    public function addAction(Product $product)
    {
        $sessionCart = $this->get('garak_demo.cart');
        $sessionCart->add($product);
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        $cart = $sessionCart->get();
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->findByIds(array_keys($cart));
        $total = $sessionCart->getTotal($products);
        
        return compact('product', 'total');
    }

    /**
     * Remove product from cart
     *
     * @Route("/{slug}/remove", name="remove", defaults={"_format"="json"})
     * @Template
     */
    public function removeAction(Product $product)
    {
        $sessionCart = $this->get('garak_demo.cart');
        $sessionCart->remove($product);
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        $cart = $sessionCart->get();
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->findByIds(array_keys($cart));
        $total = $sessionCart->getTotal($products);
        
        return compact('product', 'total');
    }
    
    /**
     * Increase product quantity in cart
     *
     * @Route("/{slug}/increase", name="increase", defaults={"_format"="json"})
     * @Template
     */
    public function increaseAction(Product $product)
    {
        $sessionCart = $this->get('garak_demo.cart');
        $sessionCart->increase($product);
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        $cart = $sessionCart->get();
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->findByIds(array_keys($cart));
        $total = $sessionCart->getTotal($products);
        
        return compact('product', 'total');
    }

    /**
     * Decrease product quantity in cart
     *
     * @Route("/{slug}/decrease", name="decrease", defaults={"_format"="json"})
     * @Template
     */
    public function decreaseAction(Product $product)
    {
        $sessionCart = $this->get('garak_demo.cart');
        $sessionCart->decrease($product);
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        $cart = $sessionCart->get();
        $products = $this->getDoctrine()->getRepository('GarakDemoBundle:Product')->findByIds(array_keys($cart));
        $total = $sessionCart->getTotal($products);
        
        return compact('product', 'total');
    }
    
    /**
     * Empty cart
     *
     * @Route("/empty", name="empty", defaults={"_format"="json"})
     * @Template
     */
    public function emptyAction()
    {
        $this->get('garak_demo.cart')->erase();
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('homepage'));
        }
    }
}
