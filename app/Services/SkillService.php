<?php

namespace App\Services;

use App\Contracts\SkillServiceInterface;
use App\Data\SkillData;
use App\Data\StoreSkillData;
use App\Data\UpdateSkillData;
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
    public function create(StoreSkillData $data): SkillData
    {
        $skill= Skill::create([
            "name"=> $data->name
        ]);

        return SkillData::from($skill);
    }

    /**
     * Get all skills.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return SkillData::collect(Skill::all()); 
    }

    /**
     * Get a skill by its ID.
     *
     * @param int $id
     * @return Skill|null
     */
    public function findById(int $id): ?SkillData
    {
        $skill =  Skill::with('jobs')->findOrFail($id);

        return SkillData::from($skill);
    }

    /**
     * Update an existing skill.
     *
     * @param int $id
     * @param UpdateSkillData $data
     * @return Skill|null
     */
    public function update(int $id, UpdateSkillData $data): ?SkillData
    {
        $skill = Skill::find($id); 
        if ($skill) {
            $skill->update([
                "name"=> $data->name
            ]); 

            return SkillData::from($skill);
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