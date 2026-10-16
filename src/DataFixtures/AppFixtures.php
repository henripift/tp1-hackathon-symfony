<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Entity\Organisateur;
use App\Entity\Participant;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Hackathons
        $hackathons = [
            ['2026-11-14 09:00', '2026-11-15 18:00', 'Cité des Congrès', 'Nantes', 'IA et santé'],
            ['2026-12-05 08:30', '2026-12-06 17:00', 'Epitech', 'Rennes', 'Ville durable'],
            ['2027-02-20 10:00', '2027-02-21 16:00', 'Station F', 'Paris', 'Cybersécurité'],
        ];
        foreach ($hackathons as [$debut, $fin, $lieu, $ville, $theme]) {
            $manager->persist((new Hackathon())
                ->setDateHeureDebut(new \DateTimeImmutable($debut))
                ->setDateHeureFin(new \DateTimeImmutable($fin))
                ->setLieu($lieu)
                ->setVille($ville)
                ->setTheme($theme));
        }

        // Organisateurs
        $organisateurs = [
            ['Association', 'Nantes Tech', 'https://nantestech.example', 'contact@nantestech.example'],
            ['Entreprise', 'CodeFactory', 'https://codefactory.example', 'hello@codefactory.example'],
            ['École', 'Lycée La Colinière', null, 'bts@coliniere.example'],
        ];
        foreach ($organisateurs as [$statut, $nom, $site, $email]) {
            $manager->persist((new Organisateur())
                ->setStatut($statut)
                ->setNom($nom)
                ->setSiteweb($site)
                ->setEmail($email));
        }

        // Projets
        $projets = [
            ['Application de suivi des rendez-vous médicaux', true],
            ['Chatbot d\'orientation pour les urgences', false],
            ['Carte interactive des pistes cyclables', true],
            ['Détecteur de phishing pour emails', false],
        ];
        foreach ($projets as [$description, $retenu]) {
            $manager->persist((new Projet())
                ->setDescription($description)
                ->setRetenu($retenu));
        }

        // Participants
        $participants = [
            ['Martin', 'Lucas', 'lucas.martin@mail.example', '0601020304', '2004-03-12', 'https://lucas-martin.example'],
            ['Bernard', 'Emma', 'emma.bernard@mail.example', '0611223344', '2005-07-25', null],
            ['Dubois', 'Hugo', 'hugo.dubois@mail.example', null, '2003-11-02', 'https://hugodubois.example'],
            ['Leroy', 'Chloé', 'chloe.leroy@mail.example', '0699887766', '2006-01-18', null],
            ['Moreau', 'Nathan', 'nathan.moreau@mail.example', '0655443322', '2004-09-30', null],
        ];
        foreach ($participants as [$nom, $prenom, $email, $tel, $naissance, $portfolio]) {
            $manager->persist((new Participant())
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->setTelephone($tel)
                ->setDateNaissance(new \DateTimeImmutable($naissance))
                ->setLienPortefolio($portfolio));
        }

        // Inscriptions
        $competences = ['PHP / Symfony', 'Design UI', 'Python / IA', 'Gestion de projet', 'Réseau'];
        foreach ($competences as $i => $competence) {
            $manager->persist((new Inscription())
                ->setNum($i + 1)
                ->setDate(new \DateTimeImmutable('2026-10-'.(10 + $i)))
                ->setCompetence($competence));
        }

        // Équipes
        $equipes = [
            ['Les Debuggers', 'https://github.com/example/debuggers'],
            ['Team Nantes', null],
            ['Null Pointers', 'https://github.com/example/null-pointers'],
        ];
        foreach ($equipes as [$nom, $prototype]) {
            $manager->persist((new Equipe())
                ->setNom($nom)
                ->setLienPrototype($prototype));
        }

        $manager->flush();
    }
}
