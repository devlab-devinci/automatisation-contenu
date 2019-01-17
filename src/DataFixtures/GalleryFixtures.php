<?php

namespace App\DataFixtures;

use App\Entity\Gallery;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GalleryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $gallery = new Gallery();
        $gallery->setPath('uploads/gallery/45c4091e4d8265.jpeg');
        $gallery->setCreatedAt(new \DateTime());
        $gallery->setUserId($this->getReference(UserFixtures::USER_REFERENCE));
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPath('uploads/gallery/45c4091e8e18fb.jpeg');
        $gallery->setCreatedAt(new \DateTime());
        $gallery->setUserId($this->getReference(UserFixtures::USER_REFERENCE));
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPath('uploads/gallery/45c4091ecc79a6.jpeg');
        $gallery->setCreatedAt(new \DateTime());
        $gallery->setUserId($this->getReference(UserFixtures::USER_REFERENCE));
        $manager->persist($gallery);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
