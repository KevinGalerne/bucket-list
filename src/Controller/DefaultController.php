<?php

namespace App\Controller;


use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route ("/", name="home")
     */
    public function home(IdeaRepository $ideaRepository)
    {

        $lastone = $ideaRepository->findtheLastOne();
        if($lastone === null){
            $lastone= new Idea;
        }
        return $this->render("default/home.html.twig", ["lastOne"=>$lastone]);
    }





}



