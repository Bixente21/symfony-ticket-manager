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

        if ($form->isSubmitted() && $form->isValid()) {
            // Assigner le statut "Nouveau" par défaut
            $statutNouveau = $statutRepository->findOneByName('Nouveau');
            $ticket->setStatut($statutNouveau);

            // La date d'ouverture est automatiquement définie dans le constructeur

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Votre ticket a été créé avec succès ! Vous recevrez une réponse dans les plus brefs délais.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'ticket_created' => $form->isSubmitted() && $form->isValid(),
        ]);
    }
}
