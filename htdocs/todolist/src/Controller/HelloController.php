<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index(Request $request): Response
    {
        $name = $request->query->get("name", "Symfony");
        
        // En PHP natif
        if (array_key_exists("name", $_GET)) {
            $name = $_GET["name"];
        } else {
            $name = "Symfony";
        }
        
        return $this->render('hello/index.html.twig', [
            "title" => "Hello " . $name
        ]);
    }
    
    /**
     * @Route("/plain", name="hello_plain")
     * 
     * @return Response
     */
    public function helloPlain(): Response {
        return new Response(
                "Hello Symfony",
                Response::HTTP_OK,
                [
                    "content-type" => "text/plain"
                ]
            );
    }
}
