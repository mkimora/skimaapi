<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Repository\userRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/api")
 */
class SecuriteController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $user = new user();
            $user->setusername($values->username);
            $user->setRoles($values->roles);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setEtatU($values->etatU);
            $user->setAdresseU($values->adresseU);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);





            $partenaire = new Partenaire();
            $partenaire->setNompartenaire($values->nompartenaire);
            $partenaire->setAdresseP($values->adresseP);
            $partenaire->setRaisonSociale($values->raisonSociale);
            $partenaire->setNinea($values->ninea);
            $partenaire->setEtatP($values->etatP);
            $partenaire->setNumcomptP($values->numcomptP);
            $partenaire->setSoldeP($values->soldeP);






            $compte = new Compte();
            $compte->setNumCompte($values->numCompte);
            $compte->setProprioCompte($values->proprioCompte);
            $compte->setDepot($values->depot);

            //relation user et partenaire
            $user->setPartenaire($partenaire);
            //relation user et compte
            $user->setCompte($compte);
            //relation partenaire et compte
            $compte->setPartenaire($partenaire);


            $entityManager->persist($user);
            $entityManager->persist($partenaire);
            $entityManager->persist($compte);
            $entityManager->flush();


            $data = [
                'statut' => 201,
                'mess' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);

            $data = [
                'statut' => 500,
                'mess' => 'Vous devez renseigner les clés username et password'
            ];
            return new JsonResponse($data, 500);
        }
    }
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getuser();
        return $this->json([
            'username' => $user->getusername(),
            'roles' => $user->getRoles()
        ]);

        if ($user->getEtatU() == "bloqué") {
            return $this->json([
                'message' => 'ACCÈS REFUSÉ'
            ]);
        }
    }


}
