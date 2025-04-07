<?php

namespace App\Controller\Admin;

use App\Entity\Image;
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
