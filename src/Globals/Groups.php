<?php

namespace App\Globals;

use App\Repository\GroupRepository;


class Groups
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function getAll()
    {
        $ggroups = $this->groupRepository->findAll();

        return $ggroups;
    }
}