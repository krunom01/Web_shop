<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\UpdateProductType;
use App\Repository\CategoryRepository;
use App\Form\ProductFormType;
use App\Form\UserFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("admin/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index")
     * @param ProductRepository $productRepository
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('admin/products.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @param CategoryRepository $categoryRepository
     */
    public function createProduct(Request $request,CategoryRepository $categoryRepository ,EntityManagerInterface $entityManager)
    {

        $form = $this->createForm(ProductFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $file = $product->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $product->setImage($fileName);
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Inserted new product!');
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/updateproduct/{id}", name="update_product")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param Product $product1
     * @return Response
     */
    public function updateProduct($id, Request $request,EntityManagerInterface $entityManager,ProductRepository $productRepository)
    {

        $product = $productRepository->find($id);
        $product->setName($product->getName());
        $product->setProductnumber($product->getProductnumber());
        $product->setPrice($product->getPrice());
        $product->setCategory($product->getCategory());
        $product->setImage(new File($this->getParameter('image_directory').'/'.$product->getImage()));

        $form = $this->createForm(UpdateProductType::class, $product);
        $form->handleRequest($request);
        if ($this->isGranted('ROLE_ADMIN') && $form->isSubmitted() && $form->isValid()) {
            /**
             * @var Product $product
             */
            $file = $product->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $product = $form->getData();
            $product->setImage($fileName);
            $entityManager->merge($product);
            $entityManager->flush();
            $this->addFlash('success', 'Updated!');
            return $this->redirectToRoute('product_index');
        }
        return $this->render('admin/updateproduct.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name="product_delete")
     */
    public function delete(Request $request, Product $product): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();


        return $this->redirectToRoute('product_index');
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
