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
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class SecuriteController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $user = new User();
            $user->setusername($values->username);
            if (strtolower($values->roles == strtolower(1))) {
                $user->setRoles(['ROLE_SUPERADMIN']);
            }
            if (strtolower($values->roles == strtolower(2))) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            if (strtolower($values->roles == strtolower(3))) {
                $user->setRoles(['ROLE_USER']);
            }

            if (strtolower($values->roles == strtolower(4))) {
                $user->setRoles(['ROLE_CAISSIER']);
            }
            //$user->setRoles($values->roles);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setEtatU($values->etatU);
            $user->setAdresseU($values->adresseU);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);





            $partenaire = new Partenaire();
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $numcomptP = $jour . $mois . $annee;
            $partenaire->setNompartenaire($values->nompartenaire);
            $partenaire->setAdresseP($values->adresseP);
            $partenaire->setRaisonSociale($values->raisonSociale);
            $partenaire->setNinea($values->ninea);
            $partenaire->setEtatP($values->etatP);
            $partenaire->setNumcomptP($numcomptP);
            $partenaire->setSoldeP($values->soldeP);






            $compte = new Compte();
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $numCompte = $jour . $mois . $annee . $heure;
            $compte->setNumCompte($numCompte);
            $compte->setProprioCompte($values->proprioCompte);
            $compte->setSoldeC($values->soldeC);

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
                'message' => 'Vous devez renseigner les clés username et password'
            ];
            return new JsonResponse($data, 500);
        }
    }
 /**
     * @Route("/login", name="login", methods={"POST"})
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request, JWTEncoderInterface  $JWTEncoder)
    { 
   
       $values = json_decode($request->getContent());
        $username   = $values->username; // json-string
        $password   = $values->password; // json-string

            $repo = $this->getDoctrine()->getRepository(User::class);
            $user = $repo-> findOneBy(['username' => $username]);
            if(!$user){
                return $this->json([
                        'message' => 'Username incorrect'
                    ]);
            }

            $isValid = $this->passwordEncoder
            ->isPasswordValid($user, $password);
            if(!$isValid){ 
                return $this->json([
                    'message' => 'Mot de passe incorect'
                ]);
            }
            if($user->getEtatU()=="bloquer"){
                return $this->json([
                    'message' => 'ACCÈS REFUSÉ'
                ]);
            }
            $token = $JWTEncoder->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 86400 // 1 day expiration
            ]);

            return $this->json([
                'token' => $token
            ]);
                
    }

    
}
