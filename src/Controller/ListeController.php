<?php

namespace App\Controller;


use App\Repository\UserRepository;
use App\Repository\PartenaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api")
 */
class ListeController extends AbstractController
{

    /**
     * @Route("/listeU", name="listeuser", methods={"GET"})
     */
    public function listeu(UserRepository $userRepository, SerializerInterface $serializer)
    {
        
        $liste = $userRepository->findAll();
        $data = $serializer->serialize($liste, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/listeP", name="listeliste", methods={"GET"})
     */
    public function listep(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        
        $listes = $partenaireRepository->findAll();
        $data = $serializer->serialize($listes, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}   
