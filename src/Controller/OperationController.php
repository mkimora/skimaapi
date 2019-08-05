<?php

namespace App\Controller;

use App\Entity\Partenaire;
use Symfony\Flex\Unpack\Operation;
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
     * @Route("/operation", name="operation")
     */

    public function depot(Request $request, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->soldeAnterieur, $values->nouveauSolde)) {
            $operation = new Operation();

            if (($values->nouveauSolde) >= 75000) {
                $operation->setSoldeAnterieur($values->soldeAnterieur);
                $operation->setNouveauSolde($values->nouveauSolde);
                $operation->setDateDepot(new \DateTime('now'));
               
            

                $entityManager->persist($operation);
                $entityManager->flush();



                $data = [
                    'statut' => 201,
                    'mess' => 'L\'utilisateur a été créé'
                ];

                return new JsonResponse($data, 201);
            } else {
                $data = [
                    'statut' => 500,
                    'mess' => 'l\'opération a échoué'
                ];
                return new JsonResponse($data, 500);
            }
        }
    }
}
