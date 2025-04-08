<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profile::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des profiles')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un profile')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un profile');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom du profile'),
            Field::new('pinCode', 'Code PIN')
                ->setHelp('Code PIN à 4 chiffres')
                ->setFormTypeOption('attr', [
                    'maxlength' => 4,
                    'pattern' => '[0-9]{4}',
                    'title' => 'Le code PIN doit contenir exactement 4 chiffres.',
                ])
                ->hideOnIndex()
                ->hideOnDetail()
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
