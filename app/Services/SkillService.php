<?php

namespace App\Services;

use App\Contracts\SkillServiceInterface;
use App\Models\Skill;
use Illuminate\Support\Collection;

class SkillService implements SkillServiceInterface
{
    /**
     * Create a new skill.
     *
     * @param array $data
     * @return Skill
     */
    public function create(array $data): Skill
    {
        return Skill::create($data);
    }

    /**
     * Get all skills.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Skill::all(); 
    }

    /**
     * Get a skill by its ID.
     *
     * @param int $id
     * @return Skill|null
     */
    public function findById(int $id): ?Skill
    {
        return Skill::find($id);
    }

    /**
     * Update an existing skill.
     *
     * @param int $id
     * @param array $data
     * @return Skill|null
     */
    public function update(int $id, array $data): ?Skill
    {
        $skill = Skill::find($id); 
        if ($skill) {
            $skill->update($data); 
            return $skill;
        }
        return null;
    }

    /**
     * Delete a Skill by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Skill::destroy($id) > 0; 
    }
}