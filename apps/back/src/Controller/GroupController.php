<?php

namespace App\Controller;

use App\Entity\Group;
use App\Service\BalanceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/group', name: 'group')]
#[IsGranted('ROLE_USER')]
class GroupController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly BalanceService $balanceService
    ){
    }

    #[Route('/{id}/balance', name: '_balance', methods: ['GET'])]
    public function viewBalance(
        int $id,
    ): Response
    {
        $groupRepository = $this->em->getRepository(Group::class);
        $group = $groupRepository->find(['id' => $id]);

        $balance = $this->balanceService->viewBalance($id);

        return $this->render('group/displayBalance.html.twig', [
            'group' => $group,
            'balance' => $balance,
        ]);
    }
}
