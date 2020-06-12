<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryFormType;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category-index", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    
    /**
     * @Route("/category/add", name="add_category", methods={"GET", "HEAD"})
     * 
     * @param Request $request
     * @return Response
     * 
     * Display CategoryFormType
     */
    public function displayAddCategoryForm(string $message = ""): Response {
        
        
        // Créer le formulaire à partir de CategoryFormType
        $form = $this->createForm(CategoryFormType::class);
        
        // Retourner une réponse vers le navigateur avec le rendu du formulaire
        return $this->render(
            "category/category-form.html.twig",
            [
                "formTitle" => "Ajouter une catégorie",
                "formCategory" => $form->createView(),
                "message" => $message
            ]
        );
    }
    
    /**
     * @Route("/category/add", name="process_category_add", methods={"POST", "HEAD"})
     * 
     * @param Request $request
     * @return Response
     * 
     * Process category adding
     */
    public function processAddCategoryForm(Request $request): Response {
        $category = new Category();
        
        // Créer le formulaire à partir de CategoryFormType
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Je dois procéder à la persistence de la donnée
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            
            $id = $category->getId();
        }
        
        return $this->displayAddCategoryForm("La catégorie : " . $id . " a bien été ajoutée.");
    }
}
