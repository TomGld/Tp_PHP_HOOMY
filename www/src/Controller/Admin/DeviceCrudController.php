<?php

namespace App\Controller\Admin;

use App\Entity\Device;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

class DeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Device::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des appareils')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un appareil')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un appareil');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label', 'Nom de l\'appareil'),
            TextField::new('type', 'Type de l\'appareil')
                ->setHelp('Type de l\'appareil (ex: Thermomètre, Humidimètre, etc.)')
                ->setFormTypeOption('attr', [
                    'maxlength' => 50,
                    'pattern' => '[A-Za-z0-9 ]{1,50}',
                    'title' => 'Le type de l\'appareil doit contenir entre 1 et 50 caractères alphanumériques.',
                ])
                ->hideOnIndex(),

            TextField::new('reference', 'Référence de l\'appareil')
                ->setHelp('Référence de l\'appareil (ex: TH-1234)')
                ->setFormTypeOption('attr', [
                    'maxlength' => 20,
                    'pattern' => '[A-Za-z0-9-]{1,20}',
                    'title' => 'La référence de l\'appareil doit contenir entre 1 et 20 caractères alphanumériques.',
                ])
                ->hideOnIndex(),

            TextField::new('brand', 'Marque de l\'appareil')
                ->setHelp('Marque de l\'appareil (ex: BrandX)')
                ->setFormTypeOption('attr', [
                    'maxlength' => 30,
                    'pattern' => '[A-Za-z0-9 ]{1,30}',
                    'title' => 'La marque de l\'appareil doit contenir entre 1 et 30 caractères alphanumériques.',
                ])
                ->hideOnIndex(),

                AssociationField::new('room', 'Salle')
                    ->setHelp('Sélectionnez la salle à laquelle cet appareil est associé.')
                    ->setFormTypeOption('attr', [
                        'title' => 'Sélectionnez la salle à laquelle cet appareil est associé.',
                    ])
                    ->hideOnIndex(),

            BooleanField::new('isActive', 'Actif')
                ->setHelp('Indique si l\'appareil est actif ou non.')
                ->hideOnIndex(),


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
