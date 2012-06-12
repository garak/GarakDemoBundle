<?php

namespace Garak\DemoBundle\Tests\Util;

use Garak\DemoBundle\Util\SessionCart;

class SessionCartTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {        
        $this->session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testGet()
    {
        $this->session->expects($this->once())
            ->method('get')
            ->will($this->returnValue(array()));
        
        $sessionCart = new SessionCart($this->session);
        $sessionCart->get();
    }

    public function testAdd()
    {
        $this->session->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue(array()));        
        
        $product = $this->getMockBuilder('Garak\DemoBundle\Entity\Product')
            ->disableOriginalConstructor()
            ->getMock();

        $product->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));   
        
        $this->session->expects($this->at(1))
            ->method('get')
            ->will($this->returnValue(array($product->getId() => 1)));   

        $this->session->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null)); 

        $sessionCart = new SessionCart($this->session);
        $sessionCart->add($product);
        
        $cart = $sessionCart->get();
    }

    public function testRemove()
    {
        $this->session->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue(array()));        
        
        $product = $this->getMockBuilder('Garak\DemoBundle\Entity\Product')
            ->disableOriginalConstructor()
            ->getMock();

        $product->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));   
        
        $this->session->expects($this->at(1))
            ->method('get')
            ->will($this->returnValue(array($product->getId() => 1)));   

        $this->session->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null)); 

        $sessionCart = new SessionCart($this->session);
        $sessionCart->remove($product);
        
        $cart = $sessionCart->get();
    }
    
    public function testIncrease()
    {
        $this->session->expects($this->once())
            ->method('get')
            ->will($this->returnValue(array()));        

        $this->session->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null)); 
        
        $product = $this->getMockBuilder('Garak\DemoBundle\Entity\Product')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionCart = new SessionCart($this->session);
        $sessionCart->increase($product);
    }

    public function testDecrease()
    {
        $this->session->expects($this->once())
            ->method('get')
            ->will($this->returnValue(array()));        

        $this->session->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null)); 
        
        $product = $this->getMockBuilder('Garak\DemoBundle\Entity\Product')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionCart = new SessionCart($this->session);
        $sessionCart->decrease($product);
    }

    public function testErase()
    {
        $this->session->expects($this->once())
            ->method('set')
            ->will($this->returnValue(null)); 

        $sessionCart = new SessionCart($this->session);
        $sessionCart->erase();
    }
}
