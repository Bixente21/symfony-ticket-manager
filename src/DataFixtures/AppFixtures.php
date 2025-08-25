<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Statut;
use App\Entity\User;
use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des catégories
        $categories = [
            ['nom' => 'Incident', 'description' => 'Problème imprévu affectant le fonctionnement normal'],
            ['nom' => 'Panne', 'description' => 'Arrêt complet d\'un service ou équipement'],
            ['nom' => 'Évolution', 'description' => 'Demande d\'amélioration ou nouvelle fonctionnalité'],
            ['nom' => 'Anomalie', 'description' => 'Comportement incorrect du système'],
            ['nom' => 'Information', 'description' => 'Demande d\'information ou de documentation'],
        ];

        $categorieEntities = [];
        foreach ($categories as $categorieData) {
            $categorie = new Categorie();
            $categorie->setNom($categorieData['nom']);
            $categorie->setDescription($categorieData['description']);
            $manager->persist($categorie);
            $categorieEntities[] = $categorie;
        }

        // Création des statuts
        $statuts = [
            ['nom' => 'Nouveau', 'description' => 'Ticket nouvellement créé, pas encore traité'],
            ['nom' => 'Ouvert', 'description' => 'Ticket en cours de traitement'],
            ['nom' => 'Résolu', 'description' => 'Ticket résolu, en attente de validation'],
            ['nom' => 'Fermé', 'description' => 'Ticket fermé et validé'],
        ];

        $statutEntities = [];
        foreach ($statuts as $statutData) {
            $statut = new Statut();
            $statut->setNom($statutData['nom']);
            $statut->setDescription($statutData['description']);
            $manager->persist($statut);
            $statutEntities[] = $statut;
        }

        // Création d'un administrateur
        $admin = new User();
        $admin->setEmail('admin@agence.com');
        $admin->setNom('Administrateur');
        $admin->setPrenom('Super');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $manager->persist($admin);

        // Création de membres du personnel
        $personnel = [
            ['email' => 'jean.dupont@agence.com', 'nom' => 'Dupont', 'prenom' => 'Jean'],
            ['email' => 'marie.martin@agence.com', 'nom' => 'Martin', 'prenom' => 'Marie'],
            ['email' => 'pierre.durand@agence.com', 'nom' => 'Durand', 'prenom' => 'Pierre'],
        ];

        $userEntities = [$admin];
        foreach ($personnel as $personData) {
            $user = new User();
            $user->setEmail($personData['email']);
            $user->setNom($personData['nom']);
            $user->setPrenom($personData['prenom']);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'password123')
            );
            $manager->persist($user);
            $userEntities[] = $user;
        }

        $manager->flush();

        // Création de tickets d'exemple
        $ticketsData = [
            [
                'auteur' => 'client1@example.com',
                'description' => 'Le site web ne se charge plus depuis ce matin. J\'ai essayé plusieurs navigateurs mais le problème persiste.',
                'categorie' => 0, // Incident
                'statut' => 0, // Nouveau
                'responsable' => 1
            ],
            [
                'auteur' => 'client2@example.com',
                'description' => 'Je souhaiterais avoir une nouvelle fonctionnalité qui permettrait d\'exporter les données en PDF.',
                'categorie' => 2, // Évolution
                'statut' => 1, // Ouvert
                'responsable' => 2
            ],
            [
                'auteur' => 'client3@example.com',
                'description' => 'L\'application mobile plante quand j\'essaie de me connecter avec mon compte utilisateur.',
                'categorie' => 3, // Anomalie
                'statut' => 2, // Résolu
                'responsable' => 3
            ],
            [
                'auteur' => 'client4@example.com',
                'description' => 'Pouvez-vous me dire comment configurer les notifications par email ? Je ne trouve pas l\'option dans les paramètres.',
                'categorie' => 4, // Information
                'statut' => 3, // Fermé
                'responsable' => 1
            ],
            [
                'auteur' => 'client5@example.com',
                'description' => 'Le serveur est complètement inaccessible depuis 2 heures. Tous nos employés sont bloqués.',
                'categorie' => 1, // Panne
                'statut' => 1, // Ouvert
                'responsable' => 0 // admin
            ],
        ];

        foreach ($ticketsData as $index => $ticketData) {
            $ticket = new Ticket();
            $ticket->setAuteur($ticketData['auteur']);
            $ticket->setDescription($ticketData['description']);
            $ticket->setCategorie($categorieEntities[$ticketData['categorie']]);
            $ticket->setStatut($statutEntities[$ticketData['statut']]);
            $ticket->setResponsable($userEntities[$ticketData['responsable']]);

            // Ajuster les dates pour certains tickets
            if ($index >= 2) {
                $ticket->setDateOuverture(new \DateTime('-' . ($index + 1) . ' days'));
            }

            // Fermer les tickets avec statut "Fermé"
            if ($ticketData['statut'] === 3) {
                $ticket->fermer();
            }

            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
