# TP1 – Hackathon : Bases de données et Doctrine ORM

**BTS SIO option SLAM – Henri PIFTEAU**

Ce TP suit les grandes étapes de la [documentation Symfony sur Doctrine](https://symfony.com/doc/current/doctrine.html).
Le but est de créer la base de données d'une application de gestion de hackathons, puis de la manipuler avec l'ORM Doctrine depuis Symfony.

---

## Environnement

| Outil | Version |
|---|---|
| PHP | 8.4 |
| Symfony | 8.1 |
| Doctrine ORM | 3.x |
| SGBD | MySQL 8.4 |
| IDE | PhpStorm |
| Client BDD | DBeaver |

---

## Modèle relationnel de départ

Dans cette version, seul le **participant** est géré : la notation par les membres du jury n'est pas prise en compte, et l'héritage depuis `Membre` est traduit par la seule relation `Participant`.

```
Hackathon (id, dateHeureDebut, dateHeureFin, lieu, ville, theme)
Organisateur (id, statut, nom, siteweb, email)
Organiser (#idHackathon, #idOrganisateur)
Projet (id, description, retenu, #idHackathon)
Participant (id, nom, prenom, email, telephone, dateNaissance, lienPortefolio)
Inscription (#idHackathon, num, date, competence, #idParticipant)
Equipe (id, nom, lienPrototype, #idProjet, #(idHackathon, num))
Regrouper (#(idHackathon, num), #idEquipe)
```

---


### 1. Mise en place de la base de données MySQL

Création de la base `hackathon` et d'un utilisateur `user_hack` ayant tous les droits sur cette base uniquement (principe du moindre privilège : l'application ne se connecte pas en `root`).

```sql
CREATE DATABASE hackathon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'user_hack'@'localhost' IDENTIFIED BY 'hack2026';
GRANT ALL PRIVILEGES ON hackathon.* TO 'user_hack'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Installation de Doctrine

Doctrine est installé via Composer (le pack ORM ajoute `doctrine/orm`, `doctrine/doctrine-bundle` et `doctrine/doctrine-migrations-bundle`) :

```bash
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

### 3. Configuration de la base de données

Dans le fichier `.env`, la variable `DATABASE_URL` indique à Doctrine comment se connecter à MySQL :

```env
DATABASE_URL="mysql://user_hack:hack2026@127.0.0.1:3306/hackathon?serverVersion=8.4.0&charset=utf8mb4"
```

> En production, les identifiants réels doivent être placés dans `.env.local` (ignoré par Git) et non dans `.env`.

### 4. Création des entités (sans les relations)

Chaque table du modèle devient une **entité** : une classe PHP dans `src/Entity/`, dont les attributs sont mappés vers les colonnes grâce aux attributs PHP `#[ORM\...]`.
Chaque entité possède aussi un **Repository** dans `src/Repository/` pour faire les requêtes.

```bash
php bin/console make:entity Hackathon
```

La commande demande pour chaque champ : son nom, son type, sa longueur et s'il peut être `null`.
Une entité peut être regénérée avec l'option `--regenerate`.

| Entité | Attributs |
|---|---|
| `Hackathon` | dateHeureDebut, dateHeureFin, lieu, ville, theme |
| `Organisateur` | statut, nom, siteweb, email |
| `Projet` | description, retenu |
| `Participant` | nom, prenom, email, telephone, dateNaissance, lienPortefolio |
| `Inscription` | num, date, competence |
| `Equipe` | nom, lienPrototype |

**Choix effectués :**
- Les clés étrangères (`idHackathon`, `idProjet`…) ne sont **pas** créées à cette étape : avec Doctrine, ce sont des **relations** entre objets (`ManyToOne`, `ManyToMany`), qui seront ajoutées dans un prochain TP.
- `Inscription` a pour l'instant un `id` auto-incrémenté en plus de `num`, car sa clé primaire composée `(idHackathon, num)` dépend d'une relation.

### 5. Migration de l'entité vers la table

Doctrine compare les entités avec la base et génère le SQL nécessaire dans une classe de migration (`migrations/VersionXXXX.php`) :

```bash
php bin/console make:migration
```

Puis la migration est exécutée sur la base MySQL :

```bash
php bin/console doctrine:migrations:migrate
```

Doctrine garde l'historique des migrations exécutées dans la table `doctrine_migration_versions`.

### 6. Jeu d'essai (Fixtures)

Installation du bundle de fixtures :

```bash
composer require --dev orm-fixtures
```

Les données de test sont écrites dans `src/DataFixtures/AppFixtures.php`. Le principe :
1. créer les objets avec `new` et les remplir avec les setters ;
2. `$manager->persist($objet)` : Doctrine prend l'objet en charge ;
3. `$manager->flush()` : Doctrine envoie les `INSERT` à la base.

```bash
php bin/console doctrine:fixtures:load
```

> Cette commande **vide** les tables avant de les remplir.

Jeu d'essai : 3 hackathons, 3 organisateurs, 4 projets, 5 participants, 5 inscriptions, 3 équipes.

### 7. Test d'interrogation de la base

Vérification que les données sont bien en base, directement depuis Symfony :

```bash
php bin/console dbal:run-sql "SELECT * FROM hackathon"
php bin/console dbal:run-sql "SELECT nom, prenom, email FROM participant"
```

- Générer une nouvelle migration pour créer les clés étrangères.
- Compléter les fixtures avec les liens entre objets.
