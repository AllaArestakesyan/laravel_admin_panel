<?php

namespace App\Http\Controllers;

use App\Contracts\SkillServiceInterface;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;

class SkillController extends Controller
{
    /**
     * Inject the skillService into the controller.
     *
     * @param SkillServiceInterface $skillService
     */
    public function __construct(private SkillServiceInterface $skillService)
    {
    }

    /**
     * Create a new skill.
     *
     * @param StoreSkillRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSkillRequest $request)
    {
        $data = $request->all();
        $skill = $this->skillService->create($data);
        return response()->json($skill, 201);
    }

    /**
     * Get all skills.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $skills = $this->skillService->findAll();
        return response()->json($skills);
    }

    /**
     * Get a skill by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $skill = $this->skillService->findById($id);
        if ($skill) {
            return response()->json($skill);
        }
        return response()->json(['message' => 'Skill not found'], 404);
    }

    /**
     * Update an existing skill.
     *
     * @param UpdateSkillRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSkillRequest $request, $id)
    {
        $data = $request->all();
        $skill = $this->skillService->update($id, $data);
        if ($skill) {
            return response()->json($skill);
        }
        return response()->json(['message' => 'Skill not found'], 404);
    }

    /**
     * Delete a skill by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $success = $this->skillService->delete($id);
        if ($success) {
            return response()->json(['message' => 'Skill deleted']);
        }
        return response()->json(['message' => 'Skill not found'], 404);
    }
}
