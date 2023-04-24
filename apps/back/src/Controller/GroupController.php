<?php

namespace App\Controller;

use App\Entity\Group;
use App\Service\BalanceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group')]
class GroupController extends AbstractController
{
    private EntityManagerInterface $em;
    private BalanceService $balanceService;

    public function __construct(
        EntityManagerInterface $em,
        BalanceService $balanceService
    ){
        $this->em = $em;
        $this->balanceService = $balanceService;
    }

    #[Route('/{groupId}/balance', name: '_balance', methods: ['GET'])]
    public function viewBalance(
        int $groupId,
    ): Response
    {
        $groupRepository = $this->em->getRepository(Group::class);
        $group = $groupRepository->find(['id' => $groupId]);

        $balance = $this->balanceService->viewBalance($groupId);

        return $this->render('group/displayBalance.html.twig', [
            'group' => $group,
            'balance' => $balance,
        ]);
    }
}
