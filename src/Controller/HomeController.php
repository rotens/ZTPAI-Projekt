<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Message;
use App\Entity\Statistics;
use App\Repository\MessageRepository;
use App\Entity\Post;


class HomeController extends AbstractController
{
    public function home(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Post::class);
        $posts = $repository->findAllOrderedByDate();
        // $results = $repository->search(
        //     "%", "%",
        //     "2018-03-02T20:19:21",
        //     "2018-11-02T20:26:21", 
        //     30, 0);
        // $objects = [];
        // $results = $repository->findYearStatistics("%");
        // foreach ($results as $obj) {
        //     $objects[] = new Statistics(2, 2, [$obj['date_year']]);
        // }
        // foreach ($objects as $object) {
        //     echo $object->id . " " . $object->numberOfMessages . "<br>";
        // }
        // foreach ($results as $obj) {
        //     echo $obj["name"] . " " . $obj["date"]->format('Y-m-d H:i:s') . " " . $obj["message"] . "<br>"; 
        // }


        return $this->render('home.html.twig', [
            "posts" => $posts
        ]);
    }
}