<?php

namespace App\Controller\Front;

use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupController extends AbstractController
{

    public function groupeList(GroupRepository $groupRepository)
    {
        $groupes = $groupRepository->findAll();

        return $this->render("front/groups.html.twig", ['groupes' => $groupes]);
    }

    public function groupShow($id, GroupRepository $groupRepository)
    {
        $groupe = $groupRepository->find($id);

        return $this->render("front/group.html.twig", ['groupe' => $groupe]);
    }
}