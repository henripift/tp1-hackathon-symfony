# TP1 Hackathon – Symfony & Doctrine ORM

**BTS SIO SLAM – Henri PIFTEAU** · PHP 8.4 · Symfony 8.1 · Doctrine ORM 3 · MySQL 8.4

## Procédure d'installation

**1. Création du projet**
```bash
composer create-project symfony/skeleton:"8.1.*" tp1-hackathon-symfony
cd tp1-hackathon-symfony
composer require webapp
composer require --dev orm-fixtures
```

**2. Création de la base et de l'utilisateur (MySQL, en root)**
```sql
CREATE DATABASE hackathon CHARACTER SET utf8mb4;
CREATE USER 'user_hack'@'localhost' IDENTIFIED BY 'hack2026';
GRANT ALL PRIVILEGES ON hackathon.* TO 'user_hack'@'localhost';
FLUSH PRIVILEGES;
```
Puis dans `.env` :
```env
DATABASE_URL="mysql://user_hack:hack2026@127.0.0.1:3306/hackathon?serverVersion=8.4.0&charset=utf8mb4"
```

**3. Entités, tables et données de test**
```bash
php bin/console make:entity Hackathon          # idem pour chaque entité
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

> Pour récupérer ce dépôt : `git clone`, `composer install`, étape 2, puis `doctrine:migrations:migrate` et `doctrine:fixtures:load`.

## Entités créées

| Entité | Attributs |
|---|---|
| Hackathon | dateHeureDebut, dateHeureFin, lieu, ville, theme |
| Organisateur | statut, nom, siteweb, email |
| Projet | description, retenu |
| Participant | nom, prenom, email, telephone, dateNaissance, lienPortefolio |
| Inscription | num, date, competence |
| Equipe | nom, lienPrototype |

**Relations du modèle** (à mapper au TP suivant, les entités de ce TP sont créées *sans* relations) :

- Hackathon **N—N** Organisateur *(table d'association `Organiser`)*
- Hackathon **1—N** Projet
- Hackathon **1—N** Inscription
- Participant **1—N** Inscription
- Projet **1—N** Equipe
- Equipe **1—N** Inscription *(membres de l'équipe, table `Regrouper`)*
- Inscription **1—N** Equipe *(inscription qui a créé l'équipe)*

```
