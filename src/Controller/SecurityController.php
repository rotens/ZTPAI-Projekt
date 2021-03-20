<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    public function changePassword(): Response
    {
        return $this->render('change_password.html.twig');
    }
}