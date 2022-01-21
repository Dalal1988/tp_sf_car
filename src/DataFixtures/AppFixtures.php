<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Car;
use App\Entity\Brand;
use App\Entity\Group;
use App\Repository\BrandRepository;
use App\Repository\GroupRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $brandRepository;

    private $groupRepository;

    public function __construct(BrandRepository $brandRepository, GroupRepository $groupRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->groupRepository = $groupRepository;
    }


    public function load(
        ObjectManager $manager
    ): void {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $brand = new Brand();

            $brand->setName($faker->word);
            $brand->setCountrie($faker->word);

            $manager->persist($brand);

            $manager->flush();
        }

        for ($i = 0; $i < 8; $i++) {
            $group  = new Group();

            $group->setName($faker->word);
            $group->setCountrie($faker->word);

            $manager->persist($group);

            $manager->flush();
        }

        for ($i = 0; $i < 15; $i++) {
            $car = new Car();

            $id_brand = rand(91, 100);
            $id_group = rand(57, 64);

            $brand = $this->brandRepository->find($id_brand);
            $group = $this->groupRepository->find($id_group);

            $car->setName($faker->word);
            $car->setYear($faker->integer);
            $car->setEngine($faker->word);
            $car->setDescription($faker->text);
            $car->setBrand($brand);
            $car->setGroupe($group);

            $manager->persist($car);
        }



        $manager->flush();
    }
}