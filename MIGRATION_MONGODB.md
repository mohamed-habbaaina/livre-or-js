# Migration vers MongoDB

Ce document explique la migration de l'application du livre d'or de PostgreSQL vers MongoDB.

## Changements principaux

### 1. Base de données
- **Avant** : PostgreSQL avec tables relationnelles
- **Après** : MongoDB avec collections et documents

### 2. Structure des données

#### Collection `utilisateurs`
```json
{
  "_id": ObjectId("..."),
  "email": "user@example.com",
  "login": "username",
  "password": "hashed_password"
}
```

#### Collection `commentaires`
```json
{
  "_id": ObjectId("..."),
  "commentaire": "Contenu du commentaire",
  "id_utilisateur": ObjectId("..."),
  "date": ISODate("...")
}
```

### 3. Fichiers modifiés

- `composer.json` : Ajout du driver MongoDB PHP
- `docker-compose.yml` : Remplacement de PostgreSQL par MongoDB
- `Dockerfile` : Installation de l'extension MongoDB PHP
- `class/User.php` : Réécriture complète pour utiliser MongoDB
- `database/init-mongo.js` : Script d'initialisation MongoDB
- Tests mis à jour pour MongoDB

## Installation et utilisation

### 1. Prérequis
- Docker et Docker Compose
- PHP 8.1+ avec extension MongoDB

### 2. Démarrage de l'application

```bash
# Construire et démarrer les conteneurs
docker-compose up --build

# L'application sera accessible sur http://localhost:8080
# MongoDB sera accessible sur le port 27017
```

### 3. Données initiales
MongoDB sera initialisé avec :
- Collections `utilisateurs` et `commentaires`
- Index unique sur le login
- Index sur l'email
- Index de tri sur la date des commentaires

### 4. Tests

```bash
# Exécuter les tests PHPUnit
docker-compose exec web vendor/bin/phpunit tests/
```

## Avantages de MongoDB

1. **Flexibilité du schéma** : Possibilité d'ajouter facilement de nouveaux champs
2. **Performance** : Meilleure performance pour les requêtes de lecture
3. **Scalabilité** : Facilité de mise à l'échelle horizontale
4. **Agrégation** : Pipeline d'agrégation puissant pour les requêtes complexes

## Points d'attention

1. **ObjectId** : Les IDs sont maintenant des ObjectId MongoDB au lieu d'entiers
2. **Dates** : Utilisation de UTCDateTime pour les dates
3. **Jointures** : Utilisation du pipeline d'agrégation `$lookup` au lieu des JOINs SQL
4. **Tests** : Les tests ont été adaptés pour MongoDB

## API inchangée

L'interface publique de la classe `User` reste identique, garantissant que le reste de l'application fonctionne sans modification.
