<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        //permet de renommer les différentes pages
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des administrateur')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un administrateur')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un administrateur');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('password', 'Mot de passe')
                ->hideOnIndex()
                ->hideOnDetail()
                ,
        ];
    }

    //fonction pour agir sur les boutons d'actions
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            //on redéfinit les boutons d'actions de la page index
            ->update(
                Crud::PAGE_INDEX,
                Action::NEW,
                fn(Action $action) => $action
                    ->setIcon('fa fa-plus')
                    ->setLabel('Ajouter')
                    ->setCssClass('btn btn-success')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
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
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
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
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
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
                ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])

        )
            ->remove(
                Crud::PAGE_DETAIL,
                Action::DELETE,
                fn(Action $action) => $action
                    ->setIcon('fa fa-trash')
                    ->setLabel('Supprimer')
            )
            ->update(
                Crud::PAGE_DETAIL,
                Action::INDEX,
                fn(Action $action) => $action
                    ->setIcon('fa fa-list')
                    ->setLabel('Retour à la liste')
            );
    }


}
