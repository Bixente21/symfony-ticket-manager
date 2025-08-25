<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Statut;
use App\Entity\User;
use App\Repository\TicketRepository;
use App\Repository\CategorieRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $stats = [
            'totalTickets' => count($ticketRepository->findAll()),
            'openTickets' => count($ticketRepository->findOpenTickets()),
            'byStatus' => $ticketRepository->countByStatut(),
            'byCategory' => $ticketRepository->countByCategorie(),
        ];
        
        return $this->render('admin/index.html.twig', [
            'stats' => $stats,
        ]);
    }
    
    #[Route('/categories', name: 'app_admin_categories')]
    public function categories(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAllOrderedByName();
        
        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/categories/new', name: 'app_admin_categories_new')]
    public function newCategorie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $description = $request->request->get('description');
            
            if ($nom) {
                $categorie->setNom($nom);
                $categorie->setDescription($description);
                
                $entityManager->persist($categorie);
                $entityManager->flush();
                
                $this->addFlash('success', 'Catégorie créée avec succès.');
                
                return $this->redirectToRoute('app_admin_categories');
            }
        }
        
        return $this->render('admin/category_form.html.twig', [
            'categorie' => $categorie,
            'isEdit' => false,
        ]);
    }
    
    #[Route('/categories/{id}/edit', name: 'app_admin_categories_edit')]
    public function editCategorie(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $description = $request->request->get('description');
            
            if ($nom) {
                $categorie->setNom($nom);
                $categorie->setDescription($description);
                
                $entityManager->flush();
                
                $this->addFlash('success', 'Catégorie modifiée avec succès.');
                
                return $this->redirectToRoute('app_admin_categories');
            }
        }
        
        return $this->render('admin/category_form.html.twig', [
            'categorie' => $categorie,
            'isEdit' => true,
        ]);
    }
    
    #[Route('/statuts', name: 'app_admin_statuts')]
    public function statuts(StatutRepository $statutRepository): Response
    {
        $statuts = $statutRepository->findAllOrderedByName();
        
        return $this->render('admin/statuts.html.twig', [
            'statuts' => $statuts,
        ]);
    }
    
    #[Route('/statuts/new', name: 'app_admin_statuts_new')]
    public function newStatut(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statut = new Statut();
        
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $description = $request->request->get('description');
            
            if ($nom) {
                $statut->setNom($nom);
                $statut->setDescription($description);
                
                $entityManager->persist($statut);
                $entityManager->flush();
                
                $this->addFlash('success', 'Statut créé avec succès.');
                
                return $this->redirectToRoute('app_admin_statuts');
            }
        }
        
        return $this->render('admin/statut_form.html.twig', [
            'statut' => $statut,
            'isEdit' => false,
        ]);
    }
    
    #[Route('/statuts/{id}/edit', name: 'app_admin_statuts_edit')]
    public function editStatut(Request $request, Statut $statut, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $description = $request->request->get('description');
            
            if ($nom) {
                $statut->setNom($nom);
                $statut->setDescription($description);
                
                $entityManager->flush();
                
                $this->addFlash('success', 'Statut modifié avec succès.');
                
                return $this->redirectToRoute('app_admin_statuts');
            }
        }
        
        return $this->render('admin/statut_form.html.twig', [
            'statut' => $statut,
            'isEdit' => true,
        ]);
    }
    
    #[Route('/users', name: 'app_admin_users')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAllOrderedByName();
        
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}
