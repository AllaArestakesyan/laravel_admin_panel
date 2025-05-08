<?php

namespace App\Contracts;

use App\Models\Skill;
use Illuminate\Support\Collection;

interface SkillServiceInterface
{
    /**
     * Create a new skill.
     *
     * @param array $data
     * @return Skill
     * 
     */
    public function create(array $data): Skill;

    /**
     * Get all Skills.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get a skill by its ID.
     *
     * @param int $id
     * @return Skill|null
     */
    public function findById(int $id): ?Skill;

    /**
     * Update an existing skill.
     *
     * @param int $id
     * @param array $data
     * @return Skill|null
     */
    public function update(int $id, array $data): ?Skill;

    /**
     * Delete a skill by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
