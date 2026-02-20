# Système d'Enchères – Symfony

Application web d’enchères développée avec Symfony, basée sur un système de jetons et une logique de **plus petit montant unique**.

## Concept

Les utilisateurs participent à une enchère en proposant un montant.

À la fin de l’enchère, le gagnant est l’utilisateur ayant proposé **le plus petit montant joué une seule fois**.

Les montants proposés plusieurs fois sont automatiquement éliminés.

---

## Fonctionnalités

### Utilisateur
- Inscription / Authentification
- Consultation des enchères en cours
- Participation via une mise
- Déduction automatique de jetons
- Historique personnel via la page "Mes mises"

### Système
- Calcul automatique du gagnant à la fin de l’enchère
- Exclusion des montants doublés
- Gestion des enchères terminées avec affichage du gagnant
- Possibilité d’enchère sans gagnant si aucun montant unique

---

## Modèle de données

- **Utilisateur**
  - Solde de jetons
- **Enchere**
  - Dates, statut (en cours / terminée)
- **Mise**
  - Montant
  - Date de mise
  - Statut de remboursement
  - Relation avec Utilisateur
  - Relation avec Enchere

---

## Règles métier

- Chaque mise consomme des jetons
- Le calcul du gagnant se fait uniquement à la clôture
- Les montants identiques sont éliminés
- Le plus petit montant unique remporte l’enchère

---

## Stack technique

- Symfony
- Doctrine ORM
- Twig
- Base de données relationnelle
- Migrations Doctrine (gestion manuelle)

---

## Objectif pédagogique

Ce projet met en pratique :
- L’architecture MVC avec Symfony
- La gestion des relations Doctrine (ManyToOne)
- La mise en place d’une logique métier spécifique
- La gestion d’un système transactionnel (jetons)
- La manipulation d’algorithmes de sélection (plus petit montant unique)
