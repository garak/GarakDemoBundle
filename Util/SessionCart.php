<?php

namespace Garak\DemoBundle\Util;

use Doctrine\ORM\EntityManager;
use Garak\DemoBundle\Entity\Category;
use Garak\DemoBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionCart
{
    protected $session;

    /**
     * Constructor
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters, EntityManager $em)
    {
        if (isset($filters['category'])) {
            $category = array(
                'class' => get_class($filters['category']),
                'id'    => $em->getUnitOfWork()->getEntityIdentifier($filters['category']),
            );
            $filters['category'] = $category;
        }

        $this->session->set('filters', $filters);
    }

    /**
     * @return array
     */
    public function getFilters(EntityManager $em)
    {
        $filters =  $this->session->get('filters', array());
        if (isset($filters['category'])) {
            $category = $filters['category'];
            if (is_array($category) && isset($category['class']) && isset($category['id'])) {
                $filters['category'] = $em->find($category['class'], $category['id']);
            }
        }

        return $filters;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->session->get('cart', array());
    }

    /**
     * @param  array
     * @return float
     */
    public function getTotal(array $products = null)
    {
        $cart = $this->session->get('cart', array());
        $total = 0.00;
        foreach ($cart as $pid => $q) {
            if (isset($products[$pid])) {
                $total += $products[$pid]->getPrice() * $q;
            }
        }

        return $total;
    }

    /**
     * @param Product $product
     */
    public function add(Product $product)
    {
        $cart = $this->session->get('cart', array());
        if (empty($cart[$product->getId()]))  {
            $cart[$product->getId()] = 1;
        }
        $this->session->set('cart', $cart);
    }

    /**
     * @param Product $product
     */
    public function remove(Product $product)
    {
        $cart = $this->session->get('cart', array());
        if (isset($cart[$product->getId()])) {
            unset($cart[$product->getId()]);
        }
        $this->session->set('cart', $cart);
    }

    /**
     * @param Product $product
     */
    public function increase(Product $product)
    {
        $cart = $this->session->get('cart', array());
        $cart[$product->getId()] = empty($cart[$product->getId()]) ? 1 : $cart[$product->getId()] + 1;
        $this->session->set('cart', $cart);
    }

    /**
     * @param Product $product
     */
    public function decrease(Product $product)
    {
        $cart = $this->session->get('cart', array());
        $cart[$product->getId()] = empty($cart[$product->getId()]) ? 0 : $cart[$product->getId()] - 1;
        if ($cart[$product->getId()] == 0) {
            unset($cart[$product->getId()]);
        }
        $this->session->set('cart', $cart);
    }

    /**
     * Empty cart
     */
    public function erase()
    {
        $this->session->set('cart', array());
    }

    private function fix(Category $category, $em)
    {
    }
}