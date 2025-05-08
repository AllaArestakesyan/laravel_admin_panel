<?php

namespace App\Services;

use App\Contracts\JobServiceInterface;
use App\Models\Job;
use Illuminate\Support\Collection;

class JobService implements JobServiceInterface
{
    /**
     * Create a new job.
     *
     * @param array $data
     * @return Job
     */
    public function create(array $data): Job
    {
        return Job::create($data);
    }

    /**
     * Get all jobs.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Job::all(); 
    }

    /**
     * Get a job by its ID.
     *
     * @param int $id
     * @return Job|null
     */
    public function findById(int $id): ?Job
    {
        return Job::whereHas('skills')->with('skills')->find($id);
    }

    /**
     * Update an existing job.
     *
     * @param int $id
     * @param array $data
     * @return Job|null
     */
    public function update(int $id, array $data): ?Job
    {
        $job = Job::find($id); 
        if ($job) {
            $job->update($data); 
            return $job;
        }
        return null;
    }

    /**
     * Delete a Job by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Job::destroy($id) > 0; 
    }
}