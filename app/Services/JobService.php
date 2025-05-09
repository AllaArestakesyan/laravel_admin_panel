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
    public function create(array $data, int $managerId): Job
    {
        $job = Job::create([
            "title" => $data["title"],
            "description" => $data["description"],
            "budget" => $data["budget"],
            "assigned_to" => $managerId,
        ]);

        if ($data['skills']) {
            $job->skills()->attach($data["skills"]);
        }

        return $job;
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
        return Job::with('skills')->find($id);
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
            $job->update([
                "title" => $data["title"],
                "description" => $data["description"],
                "budget" => $data["budget"],
            ]);

            if ($data['skills']) {
                $job->skills()->attach($data["skills"]);
            }

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

    /**
     * Summary of removeSkills
     * 
     * @param array $data
     * @param int $id
     * @return void
     */
    public function removeSkills(int $id, array $data): ?Job
    {
        $job = Job::find($id);
        if ($job) {

            if ($data['skills']) {
                $job->skills()->detach($data["skills"]);
            }

            return $job;
        }

        return null;
    }
}