<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('home/index.html.twig', [
            'title' => 'Sport webshop',
            'categories' => $category,
        ]);
    }
}
