<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Post;
use DateTime;

class PostController extends AbstractController
{
    /**
     * @IsGranted("ROLE_FULL")
     * @Route("/addpost", name="app_addpost")
     */
    public function post(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('title', TextType::class, [
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => "Tytuł"
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'maxlength' => 15000,
                    'placeholder' => "Treść"
                ]
            ])
            ->add('addpost', SubmitType::class, [
                'label' => 'Dodaj post'
            ])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $id = $this->addPost($form->getData());

                return $this->redirectToRoute('post', ['id' => $id]);
            }
    
            return $this->render('addpost.html.twig', [
                'form' => $form->createView(),
            ]);
    }

    private function addPost(array $data): int {
        $entityManager = $this->getDoctrine()->getManager();

        $newPost = new Post();
        $newPost->setTitle($data["title"]);
        $newPost->setContent($data["content"]);
        $newPost->setAuthor($this->getUser());
        $newPost->setDate(new DateTime());

        $entityManager->persist($newPost);
        $entityManager->flush();
        
        return $newPost->getId();
    }

    /**
     * @Route("post/{id}", name="post")
     */
    public function showPost(int $id): Response
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        return $this->render('post.html.twig', [
            "post" => $post
        ]);
    }

    /**
     * @Route("removepost/{id}", name="removepost")
     */
    public function removePost(int $id): Response
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute("home");
    }
}