<?php

namespace App\Contracts;

use App\Models\Job;
use Illuminate\Support\Collection;

interface JobServiceInterface
{
    /**
     * Create a new job.
     *
     * @param array $data
     * @return Job
     * 
     */
    public function create(array $data): Job;

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
    public function findById(int $id): ?Job;

    /**
     * Update an existing job.
     *
     * @param int $id
     * @param array $data
     * @return Job|null
     */
    public function update(int $id, array $data): ?Job;

    /**
     * Delete a job by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
