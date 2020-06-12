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
     * @Route("/category", name="list_categories")
     * 
     * Affiche un tableau HTML avec l'ensemble des catégories,
     * pour chaque catégorie : un lien pour supprimer, un lien pour modifier
     * En bas du tableau, un lien pour créer une nouvelle catégorie
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
        
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            "categories" => $categories
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
                "message" => $message,
                "buttonTitle" => "Créer"
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
        
        $message = "";
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Je dois procéder à la persistence de la donnée
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($category);
                $entityManager->flush();
                
                $id = $category->getId();
                
                $message = "La catégorie : " . $id . " a bien été ajoutée.";
            } else {
                // One or more assertions was not satisfied
                $message = "Une erreur est survenue lors de la création de la catégorie.";
                
            }
        }
        
        return $this->displayAddCategoryForm($message);
    }
    
    /**
     * @Route("/category/update/{id}", name="update_category", methods={"GET","HEAD"}, requirements={"id"="\d+"})
     */
    public function displayUpdateCategory(int $id) {
        // Get the Category from the repository
        $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $category = $repository->find($id);
        
        // Create the form, and pass the $category
        $form = $this->createForm(CategoryFormType::class, $category);
        
        // Render the form view via Twig
        return $this->render(
            "category/category-form.html.twig",
            [
               "formTitle" => "Mettre à  jour \"" . $category->getTitle() . "\"",
               "formCategory" => $form->createView(),
               "message" => "",
               "buttonTitle" => "Mettre à jour"
            ]
        );
        // That's all folks !!!
    }
    
    /**
     * @Route("/category/update/{id}", methods={"POST", "HEAD"}, name="process_update_category", requirements={"id"="\d+"})
     * 
     * @param Request $request
     * @param int $id
     */
    public function processUpdateCategory(int $id, Request $request) {
        // Get the Category from the repository
        $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $category = $repository->find($id);
        
        // Create the form, and pass the $category
        $form = $this->createForm(CategoryFormType::class, $category);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($category);
            $this->getDoctrine()->getManager()->flush();
        }
        
        return $this->redirectToRoute("list_categories");
    }
    
    /**
     * @Route("/category/delete/{id}", name="delete_category", methods={"GET","HEAD"}, requirements={"id"="\d+"})
     */
    public function deleteCategory() {}
}
