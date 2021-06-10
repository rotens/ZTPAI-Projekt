<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Message;
use App\Entity\Statistics;
use App\Repository\MessageRepository;
use App\Repository\PostRepository;
use App\Entity\Post;


class HomeController extends AbstractController
{
    public function home(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Post::class);
        $posts = $repository->findAllOrderedByDate();

        return $this->render('home.html.twig', [
            "posts" => $posts
        ]);
    }
}