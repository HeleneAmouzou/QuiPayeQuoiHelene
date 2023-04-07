<?php

namespace App\DataFixtures;

use App\Entity\Expense;
use App\Entity\Group;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bad = new Group('bad', new ArrayCollection([]), new ArrayCollection([]));

        $andre = new User('Andre', 'Toto', 'andre@gmail.com', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $caro = new User('Caroline', 'Titi', 'caro@gmail.com', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $benoit = new User('Benoit', 'Tutu', 'benoit@gmail.com', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $manager->persist($andre);
        $manager->persist($caro);
        $manager->persist($benoit);

        $bad->addMember($andre);
        $bad->addMember($caro);
        $bad->addMember($benoit);
        $manager->persist($bad);

        $expense1 = new Expense('essence', new DateTimeImmutable(), 30, new ArrayCollection([$andre, $caro, $benoit]), $andre, $bad);
        $expense2 = new Expense('location terrain', new DateTimeImmutable(), 90, new ArrayCollection([$caro, $benoit]), $caro, $bad);
        $expense3 = new Expense('achat materiel', new DateTimeImmutable(), 60, new ArrayCollection([$andre, $caro, $benoit]), $benoit, $bad);
        $expense4 = new Expense('gouter fin d annee', new DateTimeImmutable(), 15, new ArrayCollection([$andre, $caro, $benoit]), $caro, $bad);
        $manager->persist($expense1);
        $manager->persist($expense2);
        $manager->persist($expense3);
        $manager->persist($expense4);

        $manager->flush();
    }
}