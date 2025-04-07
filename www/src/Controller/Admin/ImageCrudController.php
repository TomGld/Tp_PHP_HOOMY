<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;


class ImageCrudController extends AbstractCrudController
{

    private string $basePath;
    private string $uploadDir;
    private RequestStack $requestStack;


    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->basePath = 'images/'; // Valeur par défaut
        $this->uploadDir = 'public/upload/images/'; // Valeur par défaut
    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    

    public function configureCrud(Crud $crud): Crud
    {
        //permet de renommer les différentes pages
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des images')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une image')
            ->setPageTitle(Crud::PAGE_EDIT, 'Remplacer une image');
    }



    public function configureFields(string $pageName): iterable
    {
        // Définir les chemins dynamiquement en fonction de la catégorie
        $this->setPathsBasedOnCategory();

        return [
            IntegerField::new('category'),
            ImageField::new('image_path', 'Image de l\'album')
                ->setBasePath($this->basePath)
                ->setUploadDir($this->uploadDir)
                ->setUploadedFileNamePattern(
                    fn(UploadedFile $file): string => sprintf(
                        'upload_%d_%s.%s',
                        random_int(1, 999),
                        pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        $file->guessExtension()
                    )
                ),
        ];
    }

    private function setPathsBasedOnCategory(): void
    {
        // Récupérer la catégorie depuis la requête
        $category = $this->requestStack->getCurrentRequest()->query->get('category', 'avatars'); // Par défaut : avatars

        if ($category === 'icones') {
            $this->basePath = 'images/icones';
            $this->uploadDir = 'public/images/icones/';
        } else {
            $this->basePath = 'images/avatars';
            $this->uploadDir = 'public/images/avatars/';
        }
    }

    


}
