<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Form\BrandType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminGroupController extends AbstractController
{

    public function adminListGroup(GroupRepository $groupRepository)
    {
        $groups = $groupRepository->findAll();

        return $this->render("admin/groups.html.twig", ['groups' => $groups]);
    }

    public function adminShowGroup($id, GroupRepository $groupRepository)
    {
        $group = $groupRepository->find($id);

        return $this->render("admin/group.html.twig", ['group' => $group]);
    }

    public function adminUpdateGroup(
        $id,
        GroupRepository $groupRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $group = $groupRepository->find($id);

        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->handleRequest($request);

        if ($groupForm->isSubmitted() && $groupForm->isValid()) {

            $entityManagerInterface->persist($group);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_group_list");
        }


        return $this->render("admin/groupForm.html.twig", ['groupForm' => $groupForm->createView()]);
    }

    public function adminGroupCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $group = new Group();

        $groupForm = $this->createForm(GroupType::class, $group);

        $groupForm->handleRequest($request);

        if ($groupForm->isSubmitted() && $groupForm->isValid()) {

            $entityManagerInterface->persist($group);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_group_list");
        }

        return $this->render("admin/groupForm.html.twig", ['groupForm' => $groupForm->createView()]);
    }

    public function adminDeleteGroup(
        $id,
        GroupRepository $groupRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $group = $groupRepository->find($id);

        $entityManagerInterface->remove($group);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_group_list");
    }
}