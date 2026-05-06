<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Lieu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Catégories
        $categories = [
            ['nom' => 'Randonnée',       'icone' => 'fa-person-hiking',    'slug' => 'randonnee'],
            ['nom' => 'Restaurant',      'icone' => 'fa-utensils',         'slug' => 'restaurant'],
            ['nom' => 'Site historique', 'icone' => 'fa-landmark',         'slug' => 'site-historique'],
            ['nom' => 'Plage',           'icone' => 'fa-umbrella-beach',   'slug' => 'plage'],
            ['nom' => 'Point de vue',    'icone' => 'fa-binoculars',       'slug' => 'point-de-vue'],
            ['nom' => 'Nature',          'icone' => 'fa-tree',             'slug' => 'nature'],
        ];

        $cats = [];
        foreach ($categories as $data) {
            $cat = new Categorie();
            $cat->setNom($data['nom']);
            $cat->setSlug($data['slug']);
            $cat->setIcone($data['icone']);
            $manager->persist($cat);
            $cats[] = $cat;
        }

        // User test
        $user = new User();
        $user->setEmail('test@test.fr');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $manager->persist($user);

        // User admin
        $admin = new User();
        $admin->setEmail('admin@guidenormand.fr');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // Lieux
        $lieux = [
            ['titre' => 'Falaises d\'Étretat', 'desc' => 'Les célèbres falaises d\'Étretat offrent un panorama exceptionnel sur la Manche. Idéal pour une randonnée en bord de mer avec des vues à couper le souffle.', 'adresse' => 'Étretat, Seine-Maritime', 'lat' => 49.7070, 'lng' => 0.2049, 'cat' => 0],
            ['titre' => 'Mont-Saint-Michel', 'desc' => 'L\'emblématique abbaye normande, classée au patrimoine mondial de l\'UNESCO. À visiter absolument lors d\'un séjour en Normandie.', 'adresse' => 'Mont-Saint-Michel, Manche', 'lat' => 48.6361, 'lng' => -1.5115, 'cat' => 2],
            ['titre' => 'Plage du Débarquement - Omaha Beach', 'desc' => 'Lieu de mémoire incontournable, cette plage témoigne du courage des soldats alliés lors du D-Day en juin 1944.', 'adresse' => 'Saint-Laurent-sur-Mer, Calvados', 'lat' => 49.3744, 'lng' => -0.8585, 'cat' => 3],
            ['titre' => 'Forêt de Lyons', 'desc' => 'L\'une des plus belles hêtraies d\'Europe. Des sentiers balisés traversent cette forêt mystérieuse, idéale pour les randonneurs.', 'adresse' => 'Lyons-la-Forêt, Eure', 'lat' => 49.4003, 'lng' => 1.4772, 'cat' => 0],
            ['titre' => 'Château Gaillard', 'desc' => 'Impressionnant château médiéval en ruines dominant la Seine. Construit par Richard Cœur de Lion au XIIe siècle.', 'adresse' => 'Les Andelys, Eure', 'lat' => 49.2430, 'lng' => 1.4118, 'cat' => 2],
            ['titre' => 'Côte d\'Albâtre - Fécamp', 'desc' => 'Point de vue exceptionnel sur les falaises blanches de la Côte d\'Albâtre. Coucher de soleil magnifique depuis les hauteurs.', 'adresse' => 'Fécamp, Seine-Maritime', 'lat' => 49.7573, 'lng' => 0.3742, 'cat' => 4],
        ];

        // Terrains
        $terrains = [
            [
                'titre' => 'Jardin de la ferme du Val',
                'desc'  => 'Grand jardin arboré au cœur du Pays de Caux. Accès à une douche chaude et toilettes. Idéal pour les randonneurs du GR21. Terrain plat, parfait pour 2 tentes.',
                'adresse' => 'Saint-Valery-en-Caux, Seine-Maritime',
                'lat'   => 49.8674,
                'lng' => 0.7147,
                'cap'   => 4,
                'douche' => true,
                'elec' => false,
                'wc' => true,
                'wifi' => false,
                'prix' => 5.00,
            ],
            [
                'titre' => 'Prairie en bordure de forêt',
                'desc'  => 'Belle prairie calme en lisière de la forêt de Lyons. Eau courante disponible. Parfait pour les cyclotouristes et randonneurs. Vue magnifique sur la vallée.',
                'adresse' => 'Lyons-la-Forêt, Eure',
                'lat'   => 49.4003,
                'lng' => 1.4772,
                'cap'   => 6,
                'douche' => false,
                'elec' => false,
                'wc' => false,
                'wifi' => false,
                'prix' => null,
            ],
            [
                'titre' => 'Verger normand avec équipements',
                'desc'  => 'Magnifique verger de pommiers normands. Douche chaude, électricité et wifi disponibles. Accueil chaleureux, possibilité d\'acheter des produits locaux (cidre, calvados).',
                'adresse' => 'Cambremer, Calvados',
                'lat'   => 49.1503,
                'lng' => 0.0647,
                'cap'   => 8,
                'douche' => true,
                'elec' => true,
                'wc' => true,
                'wifi' => true,
                'prix' => 8.00,
            ],
        ];

        foreach ($terrains as $data) {
            $terrain = new \App\Entity\Terrain();
            $terrain->setTitre($data['titre']);
            $terrain->setDescription($data['desc']);
            $terrain->setAdresse($data['adresse']);
            $terrain->setLatitude($data['lat']);
            $terrain->setLongitude($data['lng']);
            $terrain->setCapacitePersonnes($data['cap']);
            $terrain->setADouche($data['douche']);
            $terrain->setAElectricite($data['elec']);
            $terrain->setAToilettes($data['wc']);
            $terrain->setAWifi($data['wifi']);
            $terrain->setPrixNuit($data['prix']);
            $terrain->setEstDisponible(true);
            $terrain->setCreatedAt(new \DateTimeImmutable());
            $terrain->setUser($user);
            $manager->persist($terrain);
        }

        foreach ($lieux as $data) {
            $lieu = new Lieu();
            $lieu->setTitre($data['titre']);
            $lieu->setDescription($data['desc']);
            $lieu->setAdresse($data['adresse']);
            $lieu->setLatitude($data['lat']);
            $lieu->setLongitude($data['lng']);
            $lieu->setSlug(strtolower(str_replace([' ', '\'', 'é', 'è', 'ê', 'à', 'â'], ['-', '-', 'e', 'e', 'e', 'a', 'a'], $data['titre'])));
            $lieu->setCreatedAt(new \DateTimeImmutable());
            $lieu->setEstValide(true);
            $lieu->setNombreVues(rand(10, 500));
            $lieu->setCategorie($cats[$data['cat']]);
            $lieu->setUser($user);
            $manager->persist($lieu);
        }
        // Evénements
        $evenements = [
            [
                'titre' => 'Randonnée des Falaises - Étretat',
                'desc'  => 'Grande randonnée guidée le long des falaises d\'Étretat. Départ depuis le parking de la plage. Prévoir de bonnes chaussures et un pique-nique. Distance : 12 km. Difficulté : modérée.',
                'adresse' => 'Étretat, Seine-Maritime',
                'lat'   => 49.7070,
                'lng' => 0.2049,
                'debut' => new \DateTimeImmutable('+7 days'),
                'fin'   => new \DateTimeImmutable('+7 days +4hours'),
                'places' => 20,
                'gratuit' => true,
                'prix' => null,
            ],
            [
                'titre' => 'Visite nocturne du Château Gaillard',
                'desc'  => 'Découvrez le Château Gaillard à la tombée de la nuit. Une visite guidée exceptionnelle avec éclairage spécial. Réservation obligatoire. Durée : 2h.',
                'adresse' => 'Les Andelys, Eure',
                'lat'   => 49.2430,
                'lng' => 1.4118,
                'debut' => new \DateTimeImmutable('+14 days'),
                'fin'   => new \DateTimeImmutable('+14 days +2 hours'),
                'places' => 30,
                'gratuit' => false,
                'prix' => 8.50,
            ],
            [
                'titre' => 'Festival du cidre Normand',
                'desc'  => 'Venez découvrir les meilleurs producteurs de cidre et calvados de de Normandie. Dégustations, animations et marché de producteurs locaux. Entrée libre.',
                'adresse' => 'Cambremer, Calvados',
                'lat'   => 49.1503,
                'lng' => 0.0647,
                'debut' => new \DateTimeImmutable('+21 days'),
                'fin'   => new \DateTimeImmutable('+21 days +8 hours'),
                'places' => null,
                'gratuit' => true,
                'prix' => null,
            ],
            [
                'titre' => 'Sortie Birdwatching - Baie de Seine',
                'desc'  => 'Observation des oiseaux migrateurs dans la Baie de Seine avec un ornithologue professionnel. Jumelles recommandées. Groupe limité à 12 personnes.',
                'adresse' => 'Honfleur, Calvados',
                'lat'   => 49.4183,
                'lng' => 0.2333,
                'debut' => new \DateTimeImmutable('+5 days'),
                'fin'   => new \DateTimeImmutable('+5 days +3hours'),
                'places' => 12,
                'gratuit' => false,
                'prix' => 15.00,
            ],
        ];

        foreach ($evenements as $data) {
            $evenement = new \App\Entity\Evenement();
            $evenement->setTitre($data['titre']);
            $evenement->setDescription($data['desc']);
            $evenement->setAdresse($data['adresse']);
            $evenement->setLatitude($data['lat']);
            $evenement->setLongitude($data['lng']);
            $evenement->setDateDebut($data['debut']);
            $evenement->setDateFin($data['fin']);
            $evenement->setPlacesMax($data['places']);
            $evenement->setEstGratuit($data['gratuit']);
            $evenement->setPrix($data['prix']);
            $evenement->setCreatedAt(new \DateTimeImmutable());
            $evenement->setUser($user);
            $manager->persist($evenement);
        }
        $manager->flush();
    }
}
