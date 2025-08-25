# 🎫 Système de Gestion de Tickets - Agence

## 📋 Description

Application web de gestion de tickets de support développée avec Symfony 7.3. Elle permet aux clients de créer des tickets de support et au personnel de l'agence de les gérer efficacement.

## ✨ Fonctionnalités

### 🌐 Interface Publique

-   **Création de tickets** par les visiteurs (email, description, catégorie)
-   **Page d'accueil moderne** avec design professionnel
-   **Formulaire responsive** avec validation côté client et serveur

### 👥 Gestion des Utilisateurs

-   **Authentification sécurisée** avec système de rôles
-   **Deux niveaux d'accès** : Personnel (ROLE_USER) et Administrateur (ROLE_ADMIN)
-   **Interface personnalisée** selon le rôle de l'utilisateur

### 📊 Gestion des Tickets

-   **Tableau de bord** avec vue d'ensemble
-   **Statuts de tickets** : Nouveau, Ouvert, Résolu, Fermé
-   **Attribution de responsables** aux tickets
-   **Historique complet** des modifications

### ⚙️ Administration

-   **CRUD complet** pour les catégories de tickets
-   **Gestion des statuts** personnalisables
-   **Gestion des utilisateurs** et leurs rôles
-   **Tableau de bord administrateur** avec statistiques

## 🛠️ Technologies Utilisées

-   **Framework** : Symfony 7.3
-   **Base de données** : SQLite (Doctrine ORM)
-   **Frontend** : Bootstrap 5 + Font Awesome
-   **Sécurité** : Symfony Security Component
-   **Templating** : Twig
-   **Fixtures** : Doctrine Fixtures Bundle

## 📦 Installation

### Prérequis

-   PHP 8.2 ou supérieur
-   Composer
-   Symfony CLI (optionnel)

### Étapes d'installation

1. **Cloner le projet**

    ```bash
    git clone [URL_DU_DEPOT]
    cd ticket-manager
    ```

2. **Installer les dépendances**

    ```bash
    composer install
    ```

3. **Configurer la base de données**

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

4. **Charger les données de test**

    ```bash
    php bin/console doctrine:fixtures:load
    ```

5. **Démarrer le serveur**
    ```bash
    symfony serve -d
    # ou
    php -S localhost:8000 -t public/
    ```

## 👤 Comptes de Test

### Administrateur

-   **Email** : `admin@agence.com`
-   **Mot de passe** : `admin123`
-   **Rôle** : ROLE_ADMIN

### Personnel

-   **Email** : `jean.dupont@agence.com`
-   **Mot de passe** : `password123`
-   **Rôle** : ROLE_USER

-   **Email** : `marie.martin@agence.com`
-   **Mot de passe** : `password123`
-   **Rôle** : ROLE_USER

## 📊 Données de Test

L'application est livrée avec :

-   **10 tickets d'exemple** avec différents statuts
-   **5 catégories** prédéfinies (Incident, Panne, Évolution, Anomalie, Information)
-   **4 statuts** configurés (Nouveau, Ouvert, Résolu, Fermé)
-   **3 utilisateurs** avec rôles appropriés

## 🎨 Interface Utilisateur

### Design Moderne

-   **Hero section** avec gradient professionnel
-   **Icônes Font Awesome** pour une meilleure UX
-   **Cards avec ombres** et animations subtiles
-   **Formulaires optimisés** avec validation visuelle

### Responsive

-   **Compatible mobile** et tablette
-   **Grid Bootstrap** adaptatif
-   **Navigation intuitive** avec dropdown menus

## 🔒 Sécurité

-   **Authentification par formulaire** sécurisée
-   **Hachage des mots de passe** avec bcrypt
-   **Protection CSRF** sur tous les formulaires
-   **Contrôle d'accès basé sur les rôles** (RBAC)

## 📁 Structure du Projet

```
src/
├── Controller/          # Contrôleurs (Home, Ticket, Admin, Security)
├── Entity/             # Entités Doctrine (Ticket, User, Categorie, Statut)
├── Form/               # Formulaires Symfony
├── Repository/         # Repositories personnalisés
└── DataFixtures/       # Données de test

templates/
├── base.html.twig      # Template de base
├── home/               # Page d'accueil
├── ticket/             # Gestion des tickets
├── admin/              # Interface d'administration
└── security/           # Authentification
```

## 🚀 Fonctionnalités Avancées

-   **Filtrage des tickets** par statut et responsable
-   **Compteurs en temps réel** sur le dashboard
-   **Interface d'administration complète**
-   **Gestion des dates** automatique (ouverture/fermeture)
-   **Messages flash** informatifs
-   **Validation robuste** des données

## 📈 Évolutions Possibles

-   Notifications par email
-   API REST pour applications mobiles
-   Système de priorités pour les tickets
-   Pièces jointes aux tickets
-   Historique détaillé des modifications
-   Rapports et statistiques avancés

## 🐛 Support

Pour toute question ou problème :

-   Créer un ticket dans l'application
-   Contacter l'équipe de développement

## 📄 Licence

Projet développé dans le cadre d'un exercice pédagogique.

---

_Développé avec ❤️ et Symfony_
