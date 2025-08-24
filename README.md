# Gestion d’un sac à dos d’aventurier  

## Description  
Ce projet a pour objectif de gérer l’inventaire d’un aventurier à travers :  
1. La modélisation d’un sac à dos et de ses objets (POO avec interfaces, classes abstraites et concrètes, héritage, surcharge).  
2. La mise à disposition de fonctionnalités via une API Laravel (CRUD, validation, persistance).  
3. L’affichage du contenu du sac et de ses caractéristiques grâce à Vue 3 + Inertia.js.  

---

## Fonctionnalités principales  
- Gestion du sac à dos : nombre d’éléments, poids total, volume.  
- Gestion des objets : nom, description, poids, usure, quantité.  
- Actions disponibles :  
  - Ajouter un objet  
  - Supprimer un objet  
  - Utiliser un objet (réduction quantité / augmentation usure)  
- API Laravel avec :  
  - Routes REST  
  - Contrôleurs et FormRequest pour validation  
  - Persistance avec Eloquent ORM  
- Front Vue 3 (Composition API) + Inertia.js :  
  - Tableau listant les objets et leurs caractéristiques  
  - Formulaire simple pour ajouter un objet  
  - Boutons pour supprimer ou utiliser un objet  

---

## Stack technique  
- Back-end : PHP 8+, Laravel 10, Eloquent ORM  
- Front-end : Vue 3 (Composition API), Inertia.js, TailwindCSS  
- Base de données : MySQL  


## Auteur  
Développé par Bourguignon Wilfried dans le cadre d’un test technique.  
