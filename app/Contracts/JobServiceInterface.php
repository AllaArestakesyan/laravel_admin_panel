<?php

namespace App\Contracts;

use App\Data\JobData;
use App\Data\StoreJobData;
use App\Data\UpdateJobData;
use App\Models\Job;
use Illuminate\Support\Collection;

interface JobServiceInterface
{
    /**
     * Create a new job.
     *
     * @param StoreJobData $data
     * @return JobData
     * 
     */
    public function create(StoreJobData $data, int $managerId): JobData;

    /**
     * Get all jobs.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get a job by its ID.
     *
     * @param int $id
     * @return Job|null
     */
    public function findById(int $id): ?JobData;

    /**
     * Update an existing job.
     *
     * @param int $id
     * @param UpdateJobData $data
     * @return JobData|null
     */
    public function update(int $id, UpdateJobData $data): ?JobData;

    /**
     * Delete a job by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Summary of removeSkills
     * 
     * @param array $data
     * @param int $id
     * @return JobData|null
     */
    public function removeSkills(int $id, array $data): ?JobData;
}
