<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {

        $categorie = new categories();
        $form = $this->createForm(CategoriesType::class, $categorie);
        // $categorie->setName($request->request->get('name'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();

            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }



        $categoriesRepository = $this->getDoctrine()
            ->getRepository(Categories::class)
            ->findAll();

        $form = $this->createForm(CategoriesType::class, $categorie);


        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository,
            'formulaireCategories' => $form->createView(),
        ]);
    }
}