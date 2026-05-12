<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Lieu;
use App\Entity\Terrain;
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
        // ── Catégories ──
        $categories = [
            ['nom' => 'Randonnée',       'icone' => 'fa-person-hiking',  'slug' => 'randonnee'],
            ['nom' => 'Restaurant',      'icone' => 'fa-utensils',        'slug' => 'restaurant'],
            ['nom' => 'Site historique', 'icone' => 'fa-landmark',        'slug' => 'site-historique'],
            ['nom' => 'Plage',           'icone' => 'fa-umbrella-beach',  'slug' => 'plage'],
            ['nom' => 'Point de vue',    'icone' => 'fa-binoculars',      'slug' => 'point-de-vue'],
            ['nom' => 'Nature',          'icone' => 'fa-tree',            'slug' => 'nature'],
            ['nom' => 'Musée',           'icone' => 'fa-building-columns','slug' => 'musee'],
        ];

        $cats = [];
        foreach ($categories as $data) {
            $cat = new Categorie();
            $cat->setNom($data['nom']);
            $cat->setSlug($data['slug']);
            $cat->setIcone($data['icone']);
            $manager->persist($cat);
            $cats[$data['slug']] = $cat;
        }

        // ── Utilisateurs ──
        $usersData = [
            ['email' => 'test@test.fr',      'password' => 'password', 'prenom' => 'Thomas',   'nom' => 'Dupont',   'ville' => 'Rouen'],
            ['email' => 'marie@test.fr',     'password' => 'password', 'prenom' => 'Marie',    'nom' => 'Martin',   'ville' => 'Caen'],
            ['email' => 'pierre@test.fr',    'password' => 'password', 'prenom' => 'Pierre',   'nom' => 'Bernard',  'ville' => 'Le Havre'],
            ['email' => 'sophie@test.fr',    'password' => 'password', 'prenom' => 'Sophie',   'nom' => 'Leroy',    'ville' => 'Cherbourg'],
            ['email' => 'julien@test.fr',    'password' => 'password', 'prenom' => 'Julien',   'nom' => 'Moreau',   'ville' => 'Bayeux'],
            ['email' => 'admin@guidenormand.fr', 'password' => 'admin123', 'prenom' => 'Admin', 'nom' => 'Guide',   'ville' => 'Rouen', 'role' => 'ROLE_ADMIN'],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($this->hasher->hashPassword($user, $data['password']));
            $user->setPrenom($data['prenom']);
            $user->setNom($data['nom']);
            $user->setVille($data['ville']);
            if (isset($data['role'])) $user->setRoles([$data['role']]);
            $manager->persist($user);
            $users[] = $user;
        }

        // ── Lieux ──
        $lieux = [
            ['titre' => 'Falaises d\'Étretat',             'desc' => 'Les célèbres falaises d\'Étretat offrent un panorama exceptionnel sur la Manche. Idéal pour une randonnée en bord de mer avec des vues à couper le souffle. Le sentier des douaniers longe le sommet des falaises et offre des points de vue inoubliables.', 'adresse' => 'Étretat, Seine-Maritime', 'lat' => 49.7070, 'lng' => 0.2049, 'cat' => 'randonnee', 'user' => 0],
            ['titre' => 'Mont-Saint-Michel',               'desc' => 'L\'emblématique abbaye normande, classée au patrimoine mondial de l\'UNESCO. À visiter absolument lors d\'un séjour en Normandie. La baie du Mont-Saint-Michel est classée au patrimoine mondial de l\'UNESCO depuis 1979.', 'adresse' => 'Mont-Saint-Michel, Manche', 'lat' => 48.6361, 'lng' => -1.5115, 'cat' => 'site-historique', 'user' => 1],
            ['titre' => 'Plage du Débarquement - Omaha Beach', 'desc' => 'Lieu de mémoire incontournable, cette plage témoigne du courage des soldats alliés lors du D-Day en juin 1944. Le cimetière américain de Colleville-sur-Mer est situé à proximité.', 'adresse' => 'Saint-Laurent-sur-Mer, Calvados', 'lat' => 49.3744, 'lng' => -0.8585, 'cat' => 'site-historique', 'user' => 2],
            ['titre' => 'Forêt de Lyons',                  'desc' => 'L\'une des plus belles hêtraies d\'Europe. Des sentiers balisés traversent cette forêt mystérieuse, idéale pour les randonneurs. En automne, les couleurs sont spectaculaires.', 'adresse' => 'Lyons-la-Forêt, Eure', 'lat' => 49.4003, 'lng' => 1.4772, 'cat' => 'randonnee', 'user' => 3],
            ['titre' => 'Château Gaillard',                'desc' => 'Impressionnant château médiéval en ruines dominant la Seine. Construit par Richard Cœur de Lion au XIIe siècle. La vue sur le méandre de la Seine est exceptionnelle.', 'adresse' => 'Les Andelys, Eure', 'lat' => 49.2430, 'lng' => 1.4118, 'cat' => 'site-historique', 'user' => 4],
            ['titre' => 'Côte d\'Albâtre - Fécamp',        'desc' => 'Point de vue exceptionnel sur les falaises blanches de la Côte d\'Albâtre. Coucher de soleil magnifique depuis les hauteurs. La Bénédictine de Fécamp mérite également une visite.', 'adresse' => 'Fécamp, Seine-Maritime', 'lat' => 49.7573, 'lng' => 0.3742, 'cat' => 'point-de-vue', 'user' => 0],
            ['titre' => 'Abbaye de Jumièges',              'desc' => 'Vaste monastère fondé par saint Philibert en 654, surnommée la plus belle ruine de France par Victor Hugo. Un lieu empreint de sérénité et d\'histoire.', 'adresse' => 'Jumièges, Seine-Maritime', 'lat' => 49.4328, 'lng' => 0.8192, 'cat' => 'site-historique', 'user' => 1],
            ['titre' => 'Mémorial de Caen',                'desc' => 'Musée de Caen pour la paix et l\'histoire : Seconde Guerre mondiale, débarquement de Normandie, Guerre froide. Un musée incontournable pour comprendre l\'histoire du XXe siècle.', 'adresse' => 'Caen, Calvados', 'lat' => 49.2013, 'lng' => -0.3892, 'cat' => 'musee', 'user' => 2],
            ['titre' => 'Marais Vernier',                  'desc' => 'Zone naturelle protégée offrant un panorama exceptionnel sur la boucle de la Seine. Observation des oiseaux migrateurs, chevaux Highlands et longhorns en liberté.', 'adresse' => 'Marais Vernier, Eure', 'lat' => 49.4167, 'lng' => 0.4833, 'cat' => 'nature', 'user' => 3],
            ['titre' => 'Plage de Deauville',              'desc' => 'La plage emblématique de Deauville avec ses célèbres planches et cabines de bain colorées. Station balnéaire chic et incontournable de la Côte Fleurie.', 'adresse' => 'Deauville, Calvados', 'lat' => 49.3569, 'lng' => 0.0731, 'cat' => 'plage', 'user' => 4],
            ['titre' => 'Forêt de Brotonne',               'desc' => 'Grande forêt domaniale de 6 800 hectares traversée par la Seine. Idéale pour les randonnées à pied ou à vélo. De nombreux points de vue sur les méandres de la Seine.', 'adresse' => 'La Mailleraye-sur-Seine, Seine-Maritime', 'lat' => 49.4833, 'lng' => 0.7167, 'cat' => 'randonnee', 'user' => 0],
            ['titre' => 'Château de Balleroy',             'desc' => 'Premier château Louis XIII construit en France, entouré d\'un magnifique parc. Accueille chaque année le célèbre festival de montgolfières.', 'adresse' => 'Balleroy-sur-Drôme, Calvados', 'lat' => 49.1764, 'lng' => -0.8397, 'cat' => 'site-historique', 'user' => 1],
        ];

        $lieuxEntites = [];
        foreach ($lieux as $data) {
            $lieu = new Lieu();
            $lieu->setTitre($data['titre']);
            $lieu->setDescription($data['desc']);
            $lieu->setAdresse($data['adresse']);
            $lieu->setLatitude($data['lat']);
            $lieu->setLongitude($data['lng']);
            $lieu->setSlug(strtolower(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $data['titre']))));
            $lieu->setCreatedAt(new \DateTimeImmutable('-' . rand(1, 60) . ' days'));
            $lieu->setEstValide(true);
            $lieu->setNombreVues(rand(10, 500));
            $lieu->setCategorie($cats[$data['cat']]);
            $lieu->setUser($users[$data['user']]);
            $manager->persist($lieu);
            $lieuxEntites[] = $lieu;
        }

        // ── Terrains ──
        $terrains = [
            ['titre' => 'Jardin de la ferme du Val',        'desc' => 'Grand jardin arboré au cœur du Pays de Caux. Accès à une douche chaude et toilettes. Idéal pour les randonneurs du GR21. Terrain plat, parfait pour 2 tentes.', 'adresse' => 'Saint-Valery-en-Caux, Seine-Maritime', 'lat' => 49.8674, 'lng' => 0.7147, 'cap' => 4, 'douche' => true,  'elec' => false, 'wc' => true,  'wifi' => false, 'prix' => '5.00',  'user' => 0],
            ['titre' => 'Prairie en bordure de forêt',      'desc' => 'Belle prairie calme en lisière de la forêt de Lyons. Eau courante disponible. Parfait pour les cyclotouristes et randonneurs. Vue magnifique sur la vallée.', 'adresse' => 'Lyons-la-Forêt, Eure', 'lat' => 49.4003, 'lng' => 1.4772, 'cap' => 6, 'douche' => false, 'elec' => false, 'wc' => false, 'wifi' => false, 'prix' => null,   'user' => 1],
            ['titre' => 'Verger normand avec équipements',  'desc' => 'Magnifique verger de pommiers normands. Douche chaude, électricité et wifi disponibles. Accueil chaleureux, possibilité d\'acheter des produits locaux (cidre, calvados).', 'adresse' => 'Cambremer, Calvados', 'lat' => 49.1503, 'lng' => 0.0647, 'cap' => 8, 'douche' => true,  'elec' => true,  'wc' => true,  'wifi' => true,  'prix' => '8.00',  'user' => 2],
            ['titre' => 'Jardin en bord de mer',            'desc' => 'Petit jardin paisible à 500m de la plage. Parfait pour une nuit avant de reprendre le GR21. Accès à l\'eau froide. Vue sur la mer depuis le fond du jardin.', 'adresse' => 'Veulettes-sur-Mer, Seine-Maritime', 'lat' => 49.8500, 'lng' => 0.5983, 'cap' => 3, 'douche' => false, 'elec' => false, 'wc' => true,  'wifi' => false, 'prix' => '3.00',  'user' => 3],
            ['titre' => 'Ferme bio avec accueil chaleureux','desc' => 'Grande ferme bio en pleine campagne normande. Douche chaude, toilettes sèches, électricité solaire. Petit-déjeuner payant avec produits de la ferme. Animaux de compagnie acceptés.', 'adresse' => 'Saint-Pierre-de-Varengeville, Seine-Maritime', 'lat' => 49.5000, 'lng' => 1.0167, 'cap' => 10, 'douche' => true, 'elec' => true, 'wc' => true, 'wifi' => true, 'prix' => '10.00', 'user' => 4],
            ['titre' => 'Terrain plat vue sur bocage',      'desc' => 'Terrain plat et bien protégé du vent dans le bocage normand. Point d\'eau disponible. Idéal pour les marcheurs de longue distance. Boulangerie à 2km.', 'adresse' => 'Vire-Normandie, Calvados', 'lat' => 48.8333, 'lng' => -0.8833, 'cap' => 5, 'douche' => false, 'elec' => false, 'wc' => false, 'wifi' => false, 'prix' => null, 'user' => 0],
        ];

        foreach ($terrains as $data) {
            $terrain = new Terrain();
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
            $terrain->setCreatedAt(new \DateTimeImmutable('-' . rand(1, 30) . ' days'));
            $terrain->setUser($users[$data['user']]);
            $manager->persist($terrain);
        }

        // ── Événements ──
        $evenements = [
            ['titre' => 'Randonnée des Falaises - Étretat',    'desc' => 'Grande randonnée guidée le long des falaises d\'Étretat. Départ depuis le parking de la plage. Prévoir de bonnes chaussures et un pique-nique. Distance : 12 km. Difficulté : modérée.', 'adresse' => 'Étretat, Seine-Maritime', 'lat' => 49.7070, 'lng' => 0.2049, 'debut' => '+7 days',  'fin' => '+7 days +4 hours',  'places' => 20,   'gratuit' => true,  'prix' => null,  'user' => 0],
            ['titre' => 'Visite nocturne du Château Gaillard', 'desc' => 'Découvrez le Château Gaillard à la tombée de la nuit. Une visite guidée exceptionnelle avec éclairage spécial. Réservation obligatoire. Durée : 2h.', 'adresse' => 'Les Andelys, Eure', 'lat' => 49.2430, 'lng' => 1.4118, 'debut' => '+14 days', 'fin' => '+14 days +2 hours', 'places' => 30,   'gratuit' => false, 'prix' => '8.50', 'user' => 1],
            ['titre' => 'Festival du Cidre Normand',           'desc' => 'Venez découvrir les meilleurs producteurs de cidre et calvados de Normandie. Dégustations, animations et marché de producteurs locaux. Entrée libre.', 'adresse' => 'Cambremer, Calvados', 'lat' => 49.1503, 'lng' => 0.0647, 'debut' => '+21 days', 'fin' => '+21 days +8 hours', 'places' => null, 'gratuit' => true,  'prix' => null,  'user' => 2],
            ['titre' => 'Sortie Birdwatching - Baie de Seine', 'desc' => 'Observation des oiseaux migrateurs dans la Baie de Seine avec un ornithologue professionnel. Jumelles recommandées. Groupe limité à 12 personnes.', 'adresse' => 'Honfleur, Calvados', 'lat' => 49.4183, 'lng' => 0.2333, 'debut' => '+5 days',  'fin' => '+5 days +3 hours',  'places' => 12,   'gratuit' => false, 'prix' => '15.00', 'user' => 3],
            ['titre' => 'Balade contée en forêt de Lyons',    'desc' => 'Une balade enchantée de 8km avec un conteur qui vous fera découvrir les légendes et l\'histoire de la forêt de Lyons. Pour toute la famille. Durée : 3h.', 'adresse' => 'Lyons-la-Forêt, Eure', 'lat' => 49.4003, 'lng' => 1.4772, 'debut' => '+10 days', 'fin' => '+10 days +3 hours', 'places' => 25,   'gratuit' => false, 'prix' => '5.00', 'user' => 4],
            ['titre' => 'Marché de producteurs normands',      'desc' => 'Grand marché de producteurs locaux : fromages, cidres, calvados, pommes, confiture, miel... Venez découvrir le meilleur de la gastronomie normande.', 'adresse' => 'Rouen, Seine-Maritime', 'lat' => 49.4431, 'lng' => 1.0993, 'debut' => '+3 days',  'fin' => '+3 days +6 hours',  'places' => null, 'gratuit' => true,  'prix' => null,  'user' => 0],
        ];

        foreach ($evenements as $data) {
            $evenement = new Evenement();
            $evenement->setTitre($data['titre']);
            $evenement->setDescription($data['desc']);
            $evenement->setAdresse($data['adresse']);
            $evenement->setLatitude($data['lat']);
            $evenement->setLongitude($data['lng']);
            $evenement->setDateDebut(new \DateTimeImmutable($data['debut']));
            $evenement->setDateFin(new \DateTimeImmutable($data['fin']));
            $evenement->setPlacesMax($data['places']);
            $evenement->setEstGratuit($data['gratuit']);
            $evenement->setPrix($data['prix']);
            $evenement->setCreatedAt(new \DateTimeImmutable());
            $evenement->setUser($users[$data['user']]);
            $manager->persist($evenement);
        }

        // ── Avis ──
        $avisData = [
            ['lieu' => 0, 'user' => 1, 'note' => 5, 'comment' => 'Absolument magnifique ! Les falaises sont à couper le souffle, surtout au coucher du soleil. Je recommande vivement la randonnée complète.'],
            ['lieu' => 0, 'user' => 2, 'note' => 4, 'comment' => 'Très beau site mais beaucoup de monde en été. Privilégiez une visite tôt le matin pour profiter du calme.'],
            ['lieu' => 1, 'user' => 3, 'note' => 5, 'comment' => 'Un site exceptionnel, chargé d\'histoire. La visite de l\'abbaye vaut vraiment le détour. Prévoir au moins 2h.'],
            ['lieu' => 2, 'user' => 4, 'note' => 5, 'comment' => 'Un lieu de mémoire émouvant et important. Le cimetière américain juste à côté est bouleversant.'],
            ['lieu' => 3, 'user' => 0, 'note' => 4, 'comment' => 'Forêt magnifique pour se ressourcer. Les sentiers sont bien balisés et entretenus. Parfait pour une journée en famille.'],
            ['lieu' => 6, 'user' => 1, 'note' => 5, 'comment' => 'La plus belle ruine de France ! Victor Hugo avait raison. Le site est grandiose, surtout au coucher du soleil.'],
            ['lieu' => 7, 'user' => 2, 'note' => 5, 'comment' => 'Musée incontournable pour comprendre la Seconde Guerre mondiale. Très bien fait, émouvant et pédagogique.'],
            ['lieu' => 9, 'user' => 3, 'note' => 4, 'comment' => 'Très belle plage avec les célèbres planches. Deauville est une ville élégante qui vaut le détour même hors saison.'],
        ];

        foreach ($avisData as $data) {
            $avis = new Avis();
            $avis->setNote($data['note']);
            $avis->setCommentaire($data['comment']);
            $avis->setCreatedAt(new \DateTimeImmutable('-' . rand(1, 20) . ' days'));
            $avis->setEstValide(true);
            $avis->setUser($users[$data['user']]);
            $avis->setLieu($lieuxEntites[$data['lieu']]);
            $manager->persist($avis);
        }

        $manager->flush();
    }
}