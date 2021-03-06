<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }
    /**
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\GeneratedValue()
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $id;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\User", inversedBy="userCart")
     */
    private $user;

    /**
     * @Doctrine\ORM\Mapping\Column(type="decimal", scale=2, nullable=true)
     */
    private $subTotal;

    /**
     * @Doctrine\ORM\Mapping\Column(type="decimal", scale=2, nullable=true)
     */
    private $total;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\CartItem",
     * mappedBy="cart", cascade={"persist", "remove"})
     */
    private $cartItems;

    /**
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $coupon;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", length=50, nullable=true)
     */
    private $address;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", length=50, nullable=true)
     */
    private $country;


    /**
     * @return mixed $cartItems
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSubTotal()
    {
        return $this->subTotal;
    }

    public function setSubTotal($subTotal): self
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCoupon(): ?int
    {
        return $this->coupon;
    }

    public function setCoupon(int $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country): self
    {
        $this->country = $country;

        return $this;
    }

}
