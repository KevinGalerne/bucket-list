<?php

namespace App\Controller;


use App\Entity\Idea;
use App\Entity\Rate;
use App\Form\IdeaType;
use App\Form\RateType;
use App\Repository\IdeaRepository;
use App\Repository\RateRepository;
use ContainerMSe0u4C\getRateRepositoryService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IdeaController extends AbstractController
{

    /**
     * @Route ("/tales", name="tales")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {

        // Formulaire FormType, je crée un objet Idea
        $idea = new Idea();
        // Je met la date à maintenant et la valeur isPublished à true
        $idea->setDateCreated(new \DateTime());
        $idea->setIsPublished("true");
        // Ici j'appelle mon IdeaType, c'est un fomulaire déjà crée en tant que class
        $ideaForm = $this->createForm(IdeaType::class, $idea);


        // Je vérifie que le formulaire est bien envoyé et qu'il est valid
        $ideaForm->handleRequest($request);
        if ($ideaForm->isSubmitted() && $ideaForm->isValid()){
            $em->persist($idea);
            $em->flush();
            $id=$idea->getId();


            $this->addFlash("success","YO HO HO ! The tale has been send to the council of pirates !");
            return $this->redirectToRoute('idea_details',['id'=>$idea->getId()]);

        }


        return $this->render('default/tales.html.twig', ["ideaForm" => $ideaForm->createView()]);
    }

    /**
     * @Route ("/idea_list", name="idea_list")
     */
    public function list(IdeaRepository $ideaRepository)
    {
        // Recupère l'ensemble des idées et les classe du plus récent au plus ancien
        $ideas = $ideaRepository->findBy([],["dateCreated"=>"DESC"],50);

        return $this->render('ideas/idea.html.twig',[
            "ideas"=>$ideas
        ]);
    }


    /**
     * @Route ("/ideadetails/{id}", name="idea_details", requirements={"id": "\d+"}, methods={"GET","POST"})
     * @param $id
     * @param IdeaRepository $ideaRepository
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param RateRepository $rateRepository
        * @return Response
     */
    public function details($id, IdeaRepository $ideaRepository, Request $request, EntityManagerInterface $em, RateRepository $rateRepository)
    {

        //Création d'un objet de type Rate + récupération de l'id de l'objet Idea consulté + récupération de la valeur du formulaire rate
        $finalRate= new Rate();
        $idea = $ideaRepository->find($id);
        $rate = $request->get('rate');


        // Je vérifie que $rate n'est pas vide, et j'hydrate
        if($rate) {
            $finalRate->setIdea($idea);
            $finalRate->setRate($rate);
            $em->persist($finalRate);
            $em->flush();
        }


        // Je récupère l'ensemble des résultats de la table Rate de la BDD qui correspondent à 'lidea consultée (attention, dans la bdd c'est idea_id, et ici c'est juste idea
        // et je fais la moyenne
        $rateTable = $rateRepository->findBy(['idea'=>$id]);
        $element=null;
        $number=0;
        $average=null;
        $everyElement=null;
        foreach ($rateTable as $element) {
            $number = $number + 1;
            $everyElement = $everyElement+$element->getRate();
        }
        if($number != 0){
            $average = round($everyElement/$number, 1);

        }


        return $this->render("ideas/ideadetails.html.twig", ["idea"=>$idea, "average"=>$average]);
    }

}

