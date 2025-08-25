<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketAdminType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/tickets')]
#[IsGranted('ROLE_USER')]
final class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findAllOrderedByDate();
        
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
    
    #[Route('/{id}', name: 'app_ticket_show', requirements: ['id' => '\d+'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_ticket_edit', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Le ticket a été modifié avec succès.');
            
            return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
        }
        
        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/change-status', name: 'app_ticket_change_status', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function changeStatus(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $statutNom = $request->request->get('statut_id');
        
        if ($statutNom) {
            $statut = $entityManager->getRepository('App\Entity\Statut')->findOneByName($statutNom);
            if ($statut) {
                $ticket->setStatut($statut);
                
                // Si le statut est "Fermé", on ferme le ticket
                if ($statut->getNom() === 'Fermé') {
                    $ticket->fermer();
                }
                
                $entityManager->flush();
                
                $this->addFlash('success', 'Le statut du ticket a été mis à jour.');
            }
        }
        
        return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
    }
}
