<?php

namespace App\Controller;

use Symfony\Flex\Unpack\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class OperationController extends AbstractController
{
 /**    
 * @Route("/api")
 */
class SecuriteController extends AbstractController
{
   /**
     * @Route("/operation", name="operation")
     */
   
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $operation = new Operation();
            $operation->setSoldeAnterieur($values->soldeAnterieur);
            $operation->setNouveauSolde($values->nouveauSolde);
            $operation->setDateDepot($values->dateDepot);
            $entityManager->persist($operation);
            $entityManager->flush();   
        }
    }


}

