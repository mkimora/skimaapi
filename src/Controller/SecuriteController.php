<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Compte;
use App\Form\UserType;
use App\Entity\Partenaire;
use App\Repository\UserRepository;
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
    {  // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $values = $request->request->all();
        $form->submit($values);
        $fichier = $request->files->all()['image'];
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setImageFile($fichier);
            $user->setEtatU("actif");

            $repos = $this->getDoctrine()->getRepository(Role::class);
            $roless = $repos->find($values['Role']);
            $user->setRole($roless);



            if ($roless->getLibelle() == "superadmin") {
                $user->setRoles(['ROLE_superadmin']);
            } elseif ($roless->getLibelle() == "admin") {
                $user->setRoles(['ROLE_ADMIN']);
            } elseif ($roless->getLibelle() == "user") {
                $user->setRoles(['ROLE_USER']);
            } elseif ($roless->getLibelle() == "caissier") {
                $user->setRoles(['ROLE_CAISSIER']);
            }
            // $users = $this->getUser()->getPartenaire();

            $repos = $this->getDoctrine()->getRepository(Partenaire::class);
            $part = $repos->find($values['Partenaire']);
            $user->setPartenaire($part);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $data = [
                'status1' => 201,
                'message1' => 'L\'utilisateur a été créé'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status2' => 500,
            'message2' => 'L\'insertion a échoué'
        ];
        return new JsonResponse($data, 500);
    }
    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request, JWTEncoderInterface  $JWTEncoder)
    {
        $values = json_decode($request->getContent());
        $username  = $values->username; // json-string
        $password  = $values->password; // json-string

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $username]);
        if (!$user) {
            return $this->json([
                'mess' => 'Username incorrect'
            ]);
        }

        $isValid = $this->passwordEncoder
            ->isPasswordValid($user, $password);
        if (!$isValid) {
            return $this->json([
                'mess' => 'Mot de passe incorect'
            ]);
        }
        if ($user->getEtatU() == "débloqué") {
            return $this->json([
                'mess' => 'ACCÈS REFUSÉ'
            ]);
        }
        // $token = $JWTEncoder->encode([
        //     'username' => $user->getUsername(),
        //     'exp' => time() + 86400 // 1 day expiration
        // ]);

        return $this->json([
            'token' => $token
        ]);
    }

    /**
     * @Route("/bloquer", name="bloquer", methods={"GET","POST"})
     * @Route("/debloquer", name="debloquer", methods={"GET","POST"})
     */
    public function blocage(Request $request, UserRepository $UserRepository, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        $user = $UserRepository->findOneByUsername($values->username);

        if ($user->getEtatU() == "actif") {
            $user->setEtatU("debloquer");
            $entityManager->flush();

            return $this->json([
                'message' => 'L\'utilisateur a été bloqué'
            ]);
        } else {
            $user->setEtatU("actif");
            $entityManager->flush();
            return $this->json([
                'message' => 'L\'utilisateur a été débloqué'
            ]);
        }
    }

    
}
