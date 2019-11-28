<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();
            $title = $faker->sentence(3);
            $ad->setTitle($title)
              ->setIntroduction($faker->paragraph(2))
              ->setContent('<p>'.join('</p><p>', $faker->paragraphs(3)).'</p>')
              ->setCoverImage($faker->imageUrl(1000, 300))
              ->setPrice(mt_rand(40, 200))
              ->setRooms(mt_rand(1, 5));

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $img = new Image();
                $img->setUrl($faker->imageUrl(1000, 300))
                  ->setCaption($faker->sentence())
                  ->setAd($ad);

                $manager->persist($img);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
