<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AboutusController extends AbstractController
{
    /**
     * @Route ("/aboutus", name="aboutus")
     */
    public function aboutus()
    {
        return $this->render("default/aboutus.html.twig");
    }




}



