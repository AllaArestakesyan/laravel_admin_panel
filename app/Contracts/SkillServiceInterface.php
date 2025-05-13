<?php

namespace App\Contracts;

use App\Data\SkillData;
use App\Data\StoreSkillData;
use App\Data\UpdateSkillData;
use Illuminate\Support\Collection;

interface SkillServiceInterface
{
    /**
     * Create a new skill.
     *
     * @param StoreSkillData $data
     * @return SkillData
     * 
     */
    public function create(StoreSkillData $data): SkillData;

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
     * @return SkillData|null
     */
    public function findById(int $id): ?SkillData;

    /**
     * Update an existing skill.
     *
     * @param int $id
     * @param array $data
     * @return SkillData|null
     */
    public function update(int $id, UpdateSkillData $data): ?SkillData;

    /**
     * Delete a skill by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
