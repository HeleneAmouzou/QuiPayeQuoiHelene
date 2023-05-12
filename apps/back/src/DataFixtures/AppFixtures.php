<?php

namespace App\DataFixtures;

use App\Entity\Expense;
use App\Entity\Group;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $bad = new Group('bad', new ArrayCollection([]), new ArrayCollection([]));

        $andre = new User('Andre', 'Toto', 'andre@gmail.com', new ArrayCollection([]), '111111', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $andre->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $andre, '111111'
            )
            );
        $caro = new User('Caroline', 'Titi', 'caro@gmail.com', new ArrayCollection([]), '222222', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $caro->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $caro, '222222'
            )
            );
        $benoit = new User('Benoit', 'Tutu', 'benoit@gmail.com', new ArrayCollection([]), '333333', new ArrayCollection([]), new ArrayCollection([]), new ArrayCollection([$bad]));
        $benoit->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $benoit, '333333'
            )
            );
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