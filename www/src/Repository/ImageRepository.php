<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Finder\Finder;

/**
 * @extends ServiceEntityRepository<Image>
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function getAvatars():array
    {
        $finder = new Finder();
    $finder->files()->in('images/avatars/')->sortByName();
 
    $avatars = [];
    foreach ($finder as $file) {
        $avatars[] = '/avatars/' . $file->getFilename(); // Chemin relatif pour affichage
    }
 
    return $avatars;
}

}
