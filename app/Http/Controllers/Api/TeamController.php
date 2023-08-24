<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Services\TeamService;
use Exception;
use Illuminate\Http\Request;

class TeamController extends Controller {
    private TeamService $service;

    public function __construct(TeamService $teamService) {
        $this->service = $teamService;
    }

    public function createTeam(CreateTeamRequest $request) {
        try {
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }

            $team = $this->service->createTeam($request->name, $path, $request->company_id);
            if (!$team) {
                return new Exception('Team not created');
            }

            return ResponseFormatter::success($team, 'Team created');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 400, 'failed', $e->getMessage());
        }
    }

    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        if (!$id && !$name) {
            $teams = $this->service->getAllTeams($request->company_id);
            return ResponseFormatter::success($teams->paginate($limit), 'Teams is exists');
        }

        if ($id) {
            $team = $this->service->findTeamById($id);
        }
        else {
            $team = $this->service->findTeamByName($request->company_id, $name);
        }

        if (!$team) {
            return ResponseFormatter::error(null, 404, 'not found', 'Team not found');
        }
        return ResponseFormatter::success($team, 'Team is exists');
    }

    public function updateTeam(UpdateTeamRequest $request, $id) {
        try {
            // Find team by Id
            $team = $this->service->findTeamById($id);
            if (!$team) {
                return new Exception('Team not found');
            }

            // Update logo image from Form Request
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public\icon');
            }

            $this->service->updateTeam($team, $request->name, $path, $request->company_id);
            return ResponseFormatter::success($team, 'Team updated');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function deleteTeam($id) {
        try{
            $team = $this->service->findTeamById($id);
            $team ? $team->delete() : throw new Exception('Team not found');
            return ResponseFormatter::success(null, 'Team deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }
}
