<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatisticsController extends AbstractController
{
    public function statistics(): Response
    {
        return $this->render('statistics.html.twig');
    }
}