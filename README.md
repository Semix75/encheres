# Système d’Enchères – Symfony | Logique métier avancée

Application web d’enchères développée avec Symfony mettant en œuvre une logique métier spécifique : le principe du **plus petit montant unique**.

Ce projet démontre la capacité à implémenter une règle algorithmique personnalisée, gérer des transactions utilisateurs (jetons) et structurer une application web avec une architecture propre.

---

## Contexte

Développement d’une plateforme d’enchères avec :

- Système de jetons virtuels
- Participation sécurisée aux enchères
- Calcul automatique du gagnant
- Gestion des doublons
- Suivi des mises par utilisateur

Le projet met l’accent sur la cohérence métier et l’intégrité des données.

---

## Logique métier principale

Le gagnant d’une enchère est l’utilisateur ayant proposé :

> Le plus petit montant joué une seule fois.

Les montants proposés plusieurs fois sont automatiquement exclus du calcul.

Cette règle impose :
- Analyse des données
- Filtrage des doublons
- Tri algorithmique
- Gestion des cas limites (aucun montant unique)

---

## Points techniques forts

- Architecture MVC avec Symfony
- Doctrine ORM (relations ManyToOne)
- Système transactionnel de jetons (déduction automatique)
- Migrations Doctrine (gestion maîtrisée de la base)
- Implémentation d’un algorithme métier personnalisé
- Séparation claire entre contrôleurs, services et entités
- Gestion des statuts d’enchères (en cours / terminée)

---

## Modèle de données

- `Utilisateur`
  - Solde de jetons
- `Enchere`
  - Dates, statut
- `Mise`
  - Montant
  - Date
  - Statut de remboursement
  - Relation avec Utilisateur
  - Relation avec Enchere

Les relations garantissent l’intégrité référentielle et la cohérence des participations.

---

## Compétences démontrées

- Conception d’une règle métier non standard
- Manipulation avancée de collections et filtrage algorithmique
- Gestion d’un système transactionnel
- Conception d’un modèle relationnel cohérent
- Maîtrise de Symfony & Doctrine
- Gestion d’un workflow applicatif complet (création → participation → clôture → calcul)

---

## Technologies

- Symfony
- Doctrine ORM
- Twig
- MySQL
- PHP

---

## Objectif pédagogique

Simuler un cas métier réel nécessitant :
- Une logique algorithmique personnalisée
- Une gestion rigoureuse des données
- Une architecture maintenable et évolutive

---

## Auteur

Osseni Semiyou
