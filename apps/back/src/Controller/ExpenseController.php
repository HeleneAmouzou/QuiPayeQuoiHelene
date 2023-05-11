<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Entity\Group;
use App\Exception\ExpenseWithoutParticipantsException;
use App\Form\ExpenseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Throwable;

#[Route('/expense', name: 'expense')]
#[IsGranted('ROLE_USER')]
class ExpenseController extends AbstractController
{
    #[Route('/{id}/list', name: '_list', methods: ['GET'])]
    public function expenseList(
        EntityManagerInterface $em,
        int $id,
    ): Response
    {
        $groupRepository = $em->getRepository(Group::class);
        $group = $groupRepository->find($id);

        if($group === null) {
            throw new NotFoundHttpException('Ce groupe n\'existe pas.');
        }

        return $this->render('expense/list.html.twig', [
            'group' => $group,
        ]);
    }

    #[Route('/add', name: '_add', methods: ['POST', 'GET'])]
    public function addExpense(
        EntityManagerInterface $em,
        Request $request,
    ): Response
    {
        $expenseForm = $this->createForm(ExpenseType::class);
        $expenseForm->handleRequest($request);

        try {
            if ($expenseForm->isSubmitted() && $expenseForm->isValid()) {
                $expenseFormData = $expenseForm->getData();
                $expense = new Expense(
                    $expenseFormData['name'],
                    $expenseFormData['date'],
                    $expenseFormData['amount'],
                    $expenseFormData['participants'],
                    $expenseFormData['payer'],
                    $expenseFormData['group']
                );
                    $em->persist($expense);
                    $em->flush();
                    $this->addFlash('success', 'Dépense ajoutée !');
                    $id = $expense->getGroup()->getId();
                    return $this->redirectToRoute('expense_list', ['id' => $id]);
            }
        } catch (ExpenseWithoutParticipantsException $e) {
            $this->addFlash('error', 'Veuillez cocher au moins 1 participant à cette dépense.');
        } catch (Throwable $e) {
            $this->addFlash('error', 'Erreur dans le formulaire, veuillez saisir tous les champs.');
        }

        return $this->render('expense/add.html.twig', [
            'expenseForm' => $expenseForm->createView()
        ]);
    }
}
