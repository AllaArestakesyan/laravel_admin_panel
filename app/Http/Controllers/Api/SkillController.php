<?php

namespace App\Http\Controllers\Api;

use App\Contracts\SkillServiceInterface;
use App\Http\Controllers\Controller;

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
}
