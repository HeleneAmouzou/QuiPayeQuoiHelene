<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(
        EntityManagerInterface $em,
    ): Response
    {
        $groupRepository = $em->getRepository(Group::class);
        $groups = $groupRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_home_index'=>'HomeController',
            'groups' => $groups,
        ]);
    }
}
