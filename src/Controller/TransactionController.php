<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", name="transactions", methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $transaction = new Transaction();
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $transactions = $jour . $mois . $annee . $heure;

        $form = $this->createForm(TransactionType::class, $transaction);
        // $form->handleRequest($request);
        $values = $request->request->all();
        $form->submit($values);
        
        if ($form->isSubmitted()) {

        $transaction->setCode($transactions);
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transaction);
        $entityManager->flush();
        $data = [
            'status1' => 201,
            'message1' => 'La transaction a été un succés'
        ];
        return new JsonResponse($data, 201);

    }
        $data = [
            'status2' => 500,
            'message2' => 'La transaction a échoué'
        ];
        return new JsonResponse($data, 500);

    

        // recuperer la valeur du frais
        // $repository = $this->getDoctrine()->getRepository(Tarif::class);
        // $commission = $repository->findAll();

        //recuperer la valeur du montant saisie
       // $montant = $transaction->getMontant();

        //Verifier si le montant est disponible en solde 
        // $comptes = $this->getUser()->getCompte();
        // if ($transaction->getMontant() >= $comptes->getSolde()) {
        //     return $this->json([
        //         'message18' => 'votre solde( ' . $comptes->getSolde() . ' ) ne vous permez pas d\'effectuer cet envoie'
        //     ]);
        // }

        // trouver les frais qui correspond au montant
        // foreach ($commission as $values) {
        //     $values->getBorneInferieure();
        //     $values->getBorneSuperieure();
        //     $values->getValeur();
        //     if ($montant >= $values->getBorneInferieure() &&  $montant <= $values->getBorneSuperieure()) {
        //         $valeur = $values->getValeur();
        //     }
        // }
        // $transaction->setFrais($valeur);

        // $wari = ($valeur * 40) / 100;
        // $part = ($valeur * 20) / 100;
        // $etat = ($valeur * 30) / 100;

        // $comptes->setSolde($comptes->getSolde() - $transaction->getMontant() + $wari);

        // $transaction->setCommissionWari($wari);
        // $transaction->setCommissionPartenaire($part);
        // $transaction->setCommissionEtat($etat);

        // $total = $montant + $valeur;
        // $transaction->setTotal($total);
    }
}
