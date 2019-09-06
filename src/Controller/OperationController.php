<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Operation;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**    
 * @Route("/api")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/operation", name="depot", methods={"POST"})
     */

    public function depot(Request $request, EntityManagerInterface $entityManager)
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);

        $form->handleRequest($request);
        $values = $request->request->all();
       // $values=json_decode($request->getContent(),true);
        $form->submit($values);
        dump($values);


        if ($form->isSubmitted()) {

            //$repo = $this->getDoctrine()->getRepository(Compte::class);
            //$compte = $repo->findOneBy(['numCompte' => $values->numCompte]);
            $compte=$operation->getCompte();

            $soldeAnterieur = $compte->getSoldeC();
            $compte->setSoldeC($operation->getNouveauSolde() +  $compte->getSoldeC());
            $entityManager->persist($compte);
            $entityManager->flush();


            if ($compte) {

                $operation->setCompte($compte);
                $operation->setSoldeAnterieur($soldeAnterieur);
                $operation->setNouveauSolde($compte->getSoldeC());
                $operation->setDateDepot(new \DateTime());

                $user=$this->getUser();
                $repo = $this->getDoctrine()->getRepository(User::class);
                $user1 = $repo->find($user);

                $operation->setUser($user1);

                $entityManager->persist($operation);
                $entityManager->flush();
            }

            $data = [
                'statut' => 201,
                'mess' => 'Le dépôt a été un succès.'
            ];

            return new JsonResponse($data, 201);
        } else {
            $data = [
                'statut' => 500,
                'mess' => 'L\'opération a échoué.'
            ];
            return new JsonResponse($data, 500);
        }

        //$user = $this->getUser();

        //$values = json_decode($request->getContent());
        // if (($values->nouveauSolde) >= 75000) {
        // $repo = $this->getDoctrine()->getRepository(Compte::class);
        // $compte = $repo->findOneBy(['numCompte' => $values->numCompte]);
        // $soldeAnterieur = $compte->getSoldeC();
        // $compte->setSoldeC($values->nouveauSolde + $soldeAnterieur);
        // $entityManager->persist($compte);
        // $entityManager->flush();

        // if ($compte) {
        //     $operation = new Operation();
        //     $operation->setCompte($compte);
        //     $operation->setSoldeAnterieur($soldeAnterieur);
        //     $operation->setNouveauSolde($values->nouveauSolde);
        //     $operation->setDateDepot(new \DateTime('now'));

        //      $repo = $this->getDoctrine()->getRepository(User::class);
        //      $user1 = $repo->find($user);

        //     $operation->setUser($user1);


        //     $entityManager->persist($operation);
        //     $entityManager->flush();



    }
    
}
