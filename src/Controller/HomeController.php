<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Statut;
use App\Form\TicketType;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager, StatutRepository $statutRepository): Response
    {
        // Créer un nouveau ticket
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Assigner le statut "Nouveau" par défaut
                $statutNouveau = $statutRepository->findOneByName('Nouveau');
                if (!$statutNouveau) {
                    $this->addFlash('error', '❌ Statut "Nouveau" introuvable !');
                } else {
                    $ticket->setStatut($statutNouveau);

                    $entityManager->persist($ticket);
                    $entityManager->flush();

                    // Générer un message avec le numéro de ticket
                    $numeroTicket = 'TCK-' . str_pad($ticket->getId(), 6, '0', STR_PAD_LEFT);

                    // Message de succès sans redirection pour test
                    $this->addFlash('success', "🎉 TICKET CRÉÉ ! Votre ticket #{$numeroTicket} a été enregistré avec succès ! Vous recevrez une réponse à : {$ticket->getAuteur()}");
                }
            } else {
                $this->addFlash('error', '❌ Formulaire invalide ! Vérifiez les erreurs ci-dessous.');
            }

            // Pas de redirection pour le moment - on reste sur la même page
            // return $this->redirectToRoute('app_home');
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'ticket_created' => $form->isSubmitted() && $form->isValid(),
        ]);
    }
}
