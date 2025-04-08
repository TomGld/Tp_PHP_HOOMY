<?php

namespace App\Controller\Admin;

use App\Entity\DataType;
use App\Entity\Device;
use App\Entity\Image;
use App\Entity\Profile;
use App\Entity\Room;
use App\Entity\SettingType;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{

    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //Redirection par defaut vers la liste des genres
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/logo/logoX2.png" alt="logo du site" style="text-align: center;" >  
            <span style="font-size: 22px; color: #F08A4F; font-weight: bold; margin-top: 10px; display: inline-block; text-align: center; width: 100%;">Administration</span>
            ')

            ->setFaviconPath('images/logo/logoSmallX2.png')
            ->renderContentMaximized(); // utilise tout l'espace de l'écran
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Aller sur le Swagger', 'fa fa-code', 'http://localhost:8080/api')->setLinkTarget('_blank');

        // Sous-menu pour les profiles
        yield MenuItem::subMenu('Profiles', 'fa fa-users')->setSubItems([
            MenuItem::linkToCrud('Ajouter un profile', 'fa fa-plus-circle', Profile::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les profiles', 'fa fa-eye', Profile::class)
        ]);

        // Sous-menu pour les Rooms
        yield MenuItem::subMenu('Pièces', 'fa fa-door-open')->setSubItems([
            MenuItem::linkToCrud('Ajouter une pièce', 'fa fa-plus-circle', Room::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les pièces', 'fa fa-eye', Room::class)
        ]);

        // 1ere section "images"
        yield MenuItem::section('Images');

        // Sous-menu pour Avatar
        yield MenuItem::subMenu('Avatar', 'fa fa-user')->setSubItems([
            MenuItem::linkToUrl('Ajouter un avatar', 'fa fa-plus-circle', $this->generateCrudUrl('avatars', Crud::PAGE_NEW)),
            MenuItem::linkToUrl('Voir les avatars', 'fa fa-eye', $this->generateCrudUrl('avatars', Crud::PAGE_INDEX)),
        ]);

        // Sous-menu pour Icône
        yield MenuItem::subMenu('Icône', 'fa fa-icons')->setSubItems([
            MenuItem::linkToUrl('Ajouter une icône', 'fa fa-plus-circle', $this->generateCrudUrl('icones', Crud::PAGE_NEW)),
            MenuItem::linkToUrl('Voir les icônes', 'fa fa-eye', $this->generateCrudUrl('icones', Crud::PAGE_INDEX)),
        ]);

        // 2eme section "types de données"
        yield MenuItem::section('Devices et paramètres');
        // Sous-menu pour les devices
        yield MenuItem::subMenu('Devices', 'fa fa-desktop')->setSubItems([
            MenuItem::linkToCrud('Ajouter un device', 'fa fa-plus-circle', Device::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les devices', 'fa fa-eye', Device::class)
        ]);
        // Sous-menu pour type de données
        yield MenuItem::subMenu('Type de données', 'fa fa-database')->setSubItems([
            MenuItem::linkToCrud('Ajouter un type de données', 'fa fa-plus-circle', DataType::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les types de données', 'fa fa-eye', DataType::class)
        ]);
        // Sous-menu pour les SettingTypes
        yield MenuItem::subMenu('Setting types', 'fa fa-cogs')->setSubItems([
            MenuItem::linkToCrud('Ajouter un paramètre', 'fa fa-plus-circle', SettingType::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les paramètres', 'fa fa-eye', SettingType::class)
        ]);




       
    }

    /**
     * Génère une URL pour le CRUD avec un paramètre de catégorie.
     */
    private function generateCrudUrl(string $category, string $action): string
    {
        return $this->adminUrlGenerator
            ->setController(ImageCrudController::class)
            ->setAction($action)
            ->set('category', $category)
            ->generateUrl();
    }
}
