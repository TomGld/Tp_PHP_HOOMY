<?php

namespace App\Controller\Admin;

use App\Entity\DataType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des types de données')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un type de données')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un type de données');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('dataType', 'Type de données')
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
                fn (Action $action) => $action
                    ->setIcon('fa fa-plus')
                    ->setLabel('Ajouter')
                    ->setCssClass('btn btn-success')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                fn (Action $action) => $action
                    ->setIcon('fa fa-pen')
                    ->setLabel('Modifier')
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                fn (Action $action) => $action
                    ->setIcon('fa fa-trash')
                    ->setLabel('Supprimer')
            )
            //on redéfinit les boutons d'actions de la page edit
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_RETURN,
                fn (Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_CONTINUE,
                fn (Action $action) => $action
                    ->setLabel('Enregistrer et continuer')
            )
            //on redéfinit les boutons d'actions de la page new
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_RETURN,
                fn (Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
                    ->setHtmlAttributes(['style' => 'background-color: #F08A4F;'])
            )
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_ADD_ANOTHER,
                fn (Action $action) => $action
                    ->setLabel('Enregistrer et ajouter un nouveau')
            );
    }

}
