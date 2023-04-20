<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group')]
class GroupController extends AbstractController
{
    #[Route('/balance/{groupName}', name: '_balance')]
    public function viewBalance(
        EntityManagerInterface $em,
        string $groupName,
        KernelInterface $kernel,
    ): Response
    {
        $groupRepository = $em->getRepository(Group::class);
        $group = $groupRepository->findOneBy(['name' => $groupName]);

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'app:view-balance',
            'groupName' => $groupName,
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

        return $this->render('group/displayBalance.html.twig', [
            'group' => $group,
            'content' => $content,
        ]);
    }
}
