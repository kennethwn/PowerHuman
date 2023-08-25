<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository {
    protected $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function createTeam($name, $icon, $company_id): Team {
        return Team::create([
            'name' => $name,
            'icon' => $icon,
            'company_id' => $company_id
        ]);
    }

    public function updateTeam($team, $name, $icon, $company_id) {
        return $team->update([
            'name' => $name,
            'icon' => isset($icon) ? $icon : $team->icon,
            'company_id' => $company_id
        ]);
    }

    public function findTeamById($id): Team {
        return Team::find($id);
    }

    public function findTeamByName($company_id, $name): Team {
        return $this->getAllTeams($company_id)->where('name', 'like', '%'.$name.'%');
    }

    public function getAllTeams($company_id) {
        return Team::where('company_id', $company_id);
    }
}
