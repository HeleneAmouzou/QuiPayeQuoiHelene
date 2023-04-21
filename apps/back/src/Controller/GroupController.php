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

    #[Route('/balance/{groupName}', name: '_balance')]
    public function viewBalance(
        string $groupName,
    ): Response
    {
        $groupRepository = $this->em->getRepository(Group::class);
        $group = $groupRepository->findOneBy(['name' => $groupName]);

        $balance = $this->balanceService->viewBalance($groupName);

        return $this->render('group/displayBalance.html.twig', [
            'group' => $group,
            'balance' => $balance,
        ]);
    }
}
