<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

    // int pour les types
    // 2 = icones
    // 1 = avatars



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
        } elseif ($category === 'rooms') {
            $this->basePath = 'images/rooms';
            $this->uploadDir = 'public/images/rooms/';
        } else {
            $this->basePath = 'images/avatars';
            $this->uploadDir = 'public/images/avatars/';
        }
    }

    //fonction pour agir sur les boutons d'actions
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            //on redéfinit les boutons d'actions de la page index
            ->remove(
                Crud::PAGE_INDEX,
                Action::NEW,
                fn(Action $action) => $action
                    ->setIcon('fa fa-plus')
                    ->setLabel('Ajouter')
                    ->setCssClass('btn')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F; border-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                fn(Action $action) => $action
                    ->setIcon('fa fa-pen')
                    ->setLabel('Modifier')
            )
            ->remove(
                Crud::PAGE_INDEX,
                Action::DELETE,
                fn(Action $action) => $action
                    ->setIcon('fa fa-trash')
                    ->setLabel('Supprimer')
            )
            //on redéfinit les boutons d'actions de la page edit
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_RETURN,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
                    ->setCssClass('btn')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F; border-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_CONTINUE,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et continuer')
            )
            //on redéfinit les boutons d'actions de la page new
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_RETURN,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
                    ->setCssClass('btn')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F; border-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_ADD_ANOTHER,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et ajouter un nouveau')
            )
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(
                Crud::PAGE_INDEX,
                Action::DETAIL,
                fn(Action $action) => $action
                    ->setIcon('fa fa-eye')
                    ->setLabel('Voir')
            )
            ->update(
                Crud::PAGE_DETAIL,
                Action::EDIT,
                fn(Action $action) => $action
                    ->setIcon('fa fa-pen')
                    ->setLabel('Modifier')
            )
            ->remove(
                Crud::PAGE_DETAIL,
                Action::DELETE,
                fn(Action $action) => $action
                    ->setIcon('fa fa-trash')
                    ->setLabel('Supprimer')
            );
    }

}
