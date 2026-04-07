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

        // Lieux
        $lieux = [
            ['titre' => 'Falaises d\'Étretat', 'desc' => 'Les célèbres falaises d\'Étretat offrent un panorama exceptionnel sur la Manche. Idéal pour une randonnée en bord de mer avec des vues à couper le souffle.', 'adresse' => 'Étretat, Seine-Maritime', 'lat' => 49.7070, 'lng' => 0.2049, 'cat' => 0],
            ['titre' => 'Mont-Saint-Michel', 'desc' => 'L\'emblématique abbaye normande, classée au patrimoine mondial de l\'UNESCO. À visiter absolument lors d\'un séjour en Normandie.', 'adresse' => 'Mont-Saint-Michel, Manche', 'lat' => 48.6361, 'lng' => -1.5115, 'cat' => 2],
            ['titre' => 'Plage du Débarquement - Omaha Beach', 'desc' => 'Lieu de mémoire incontournable, cette plage témoigne du courage des soldats alliés lors du D-Day en juin 1944.', 'adresse' => 'Saint-Laurent-sur-Mer, Calvados', 'lat' => 49.3744, 'lng' => -0.8585, 'cat' => 3],
            ['titre' => 'Forêt de Lyons', 'desc' => 'L\'une des plus belles hêtraies d\'Europe. Des sentiers balisés traversent cette forêt mystérieuse, idéale pour les randonneurs.', 'adresse' => 'Lyons-la-Forêt, Eure', 'lat' => 49.4003, 'lng' => 1.4772, 'cat' => 0],
            ['titre' => 'Château Gaillard', 'desc' => 'Impressionnant château médiéval en ruines dominant la Seine. Construit par Richard Cœur de Lion au XIIe siècle.', 'adresse' => 'Les Andelys, Eure', 'lat' => 49.2430, 'lng' => 1.4118, 'cat' => 2],
            ['titre' => 'Côte d\'Albâtre - Fécamp', 'desc' => 'Point de vue exceptionnel sur les falaises blanches de la Côte d\'Albâtre. Coucher de soleil magnifique depuis les hauteurs.', 'adresse' => 'Fécamp, Seine-Maritime', 'lat' => 49.7573, 'lng' => 0.3742, 'cat' => 4],
        ];

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

        $manager->flush();
    }
}