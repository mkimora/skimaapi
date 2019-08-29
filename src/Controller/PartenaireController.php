<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/api")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function parte(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $password)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);

        $form->handleRequest($request);
        $values = $request->request->all();
        $form->submit($values);
        dump($values);
        if ($form->isSubmitted() ) {
            $partenaire->setEtatU('debloquer');


            $compte = new Compte();
            $solde = 0;
            $heure = date('H');
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $comptes = $heure . $jour . $mois . $annee;


            $compte->setNumCompte($comptes);
            $compte->setSoldeC($solde);
            $compte->setPartenaire($partenaire);

            $user = new User();
            $user->setTelephone($partenaire->getTelephone());
            $user->setEmail($partenaire->getEmail());
            $user->setUsername($partenaire->getUsername());
            $user->setNomCompletU($partenaire->getNomCompletU());
            $user->setPartenaire($partenaire);
            $user->setAdresseU($partenaire->getAdresseU());
            $user->setRoles(['ROLE_ADMIN']);
            $user->setEtatU('debloquer');
            $user->setPassword($password->encodePassword($user, 'entrer'));


            // dump($partenaire);
            // dump($user);
            // dump($compte);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->flush();

            $entityManager->persist($compte);
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status1' => 201,
                'message1' => 'Le partenaire a été créé'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status2' => 500,
            'message2' => 'L\'insertion a échoué'
        ];
        return new JsonResponse($data, 500);
    }


        
}
