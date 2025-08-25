# 📋 LIVRABLE - Système de Gestion de Tickets

## 🔗 Informations du Dépôt GitHub

**Lien du dépôt** : `[À COMPLÉTER APRÈS CRÉATION DU DÉPÔT]`

> **Note** : Pour créer le dépôt GitHub, suivez ces étapes :
>
> 1. Allez sur [GitHub.com](https://github.com)
> 2. Cliquez sur "New repository"
> 3. Nommez le dépôt : `symfony-ticket-manager`
> 4. Rendez-le public ou privé selon vos préférences
> 5. Ajoutez ce dépôt local avec :
>     ```bash
>     git remote add origin [URL_DU_DEPOT_GITHUB]
>     git branch -M main
>     git push -u origin main
>     ```

## 👨‍💼 Compte Administrateur

### Identifiants de Connexion

-   **Adresse email** : `admin@agence.com`
-   **Mot de passe** : `admin123`
-   **Rôle** : Administrateur (ROLE_ADMIN)

### Privilèges Administrateur

-   ✅ Accès au tableau de bord administrateur
-   ✅ Gestion complète des tickets (CRUD)
-   ✅ Gestion des catégories (CRUD)
-   ✅ Gestion des statuts (CRUD)
-   ✅ Gestion des utilisateurs (consultation)
-   ✅ Statistiques et rapports
-   ✅ Attribution de responsables aux tickets

## 🚀 Démarrage Rapide

### Installation

```bash
# 1. Cloner le projet
git clone [URL_DU_DEPOT]
cd symfony-ticket-manager

# 2. Installer les dépendances
composer install

# 3. Configurer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 4. Charger les données de test
php bin/console doctrine:fixtures:load

# 5. Démarrer le serveur
symfony serve -d
```

### Accès à l'Application

-   **URL locale** : `http://127.0.0.1:8000`
-   **Page d'administration** : Se connecter avec le compte admin puis accéder au menu "Administration"

## 📊 Données de Test Incluses

L'application est livrée avec :

-   **10 tickets d'exemple** avec différents statuts et catégories
-   **5 catégories** prédéfinies (Incident, Panne, Évolution, Anomalie, Information)
-   **4 statuts** configurés (Nouveau, Ouvert, Résolu, Fermé)
-   **3 utilisateurs** : 1 admin + 2 membres du personnel

## 🎯 Fonctionnalités Testables

### Interface Publique

1. Créer un ticket depuis la page d'accueil
2. Vérifier la validation du formulaire
3. Confirmer la création avec le message de succès

### Interface Administrateur

1. Se connecter avec `admin@agence.com` / `admin123`
2. Accéder au tableau de bord administrateur
3. Gérer les tickets, catégories et statuts
4. Consulter les statistiques

### Interface Personnel

1. Se connecter avec `jean.dupont@agence.com` / `password123`
2. Consulter la liste des tickets
3. Modifier le statut d'un ticket
4. Filtrer les tickets par statut

## 🔧 Technologies Utilisées

-   **Framework** : Symfony 7.3
-   **Base de données** : SQLite avec Doctrine ORM
-   **Frontend** : Bootstrap 5 + Font Awesome
-   **Authentification** : Symfony Security Component
-   **Templating** : Twig

## 📁 Structure du Projet

Le projet respecte l'architecture Symfony avec :

-   Controllers pour la logique métier
-   Entities pour les modèles de données
-   Forms pour la gestion des formulaires
-   Templates Twig pour l'affichage
-   Repositories pour les requêtes personnalisées
-   Fixtures pour les données de test

## ✅ Checklist de Validation

-   [x] Interface publique de création de tickets
-   [x] Système d'authentification fonctionnel
-   [x] Gestion complète des tickets (CRUD)
-   [x] Interface d'administration
-   [x] Gestion des catégories et statuts
-   [x] Design responsive et professionnel
-   [x] Données de test complètes
-   [x] Documentation README détaillée
-   [x] Code versionné avec Git

---

**Date de livraison** : 25 août 2025  
**Développeur** : [Votre nom]  
**Version** : 1.0
