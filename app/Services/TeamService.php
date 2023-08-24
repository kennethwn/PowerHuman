<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\TeamRepository;

class TeamService {
    private $repository;

    public function __construct(TeamRepository $teamRepository) {
        $this->repository = $teamRepository;
    }

    public function createTeam($name, $icon, $company_id): Team {
        return $this->repository->createTeam($name, $icon, $company_id);
    }

    public function updateTeam($team, $name, $icon, $company_id) {
        return $this->repository->updateTeam($team, $name, $icon, $company_id);
    }

    public function findTeamById($id): Team {
        return $this->repository->findTeamById($id);
    }

    public function findTeamByName($company_id, $name): Team {
        return $this->repository->findTeamById($company_id, $name);
    }

    public function getAllTeams($company_id) {
        return $this->repository->getAllTeams($company_id);
    }
}
