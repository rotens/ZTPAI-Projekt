<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Message;
use App\Repository\MessageRepository;


class HomeController extends AbstractController
{
    public function home(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Message::class);
        // $results = $repository->search(
        //     "%", "%",
        //     "2018-03-02T20:19:21",
        //     "2018-11-02T20:26:21", 
        //     30, 0);


        // foreach ($results as $obj) {
        //     echo $obj["name"] . " " . $obj["date"]->format('Y-m-d H:i:s') . " " . $obj["message"] . "<br>"; 
        // }

        
        

        return $this->render('home.html.twig');
    }
}