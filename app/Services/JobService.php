<?php

namespace App\Services;

use App\Contracts\JobServiceInterface;
use App\Data\JobData;
use App\Data\StoreJobData;
use App\Data\UpdateJobData;
use App\Models\Job;
use Illuminate\Support\Collection;

class JobService implements JobServiceInterface
{
    /**
     * Create a new job.
     *
     * @param StoreJobData $data
     * @return JobData
     */
    public function create(StoreJobData $data, int $managerId): JobData
    {
        $job = Job::create([
            "title" => $data->title,
            "description" => $data->description,
            "budget" => $data->budget,
            "assigned_to" => $managerId,
        ]);

        if ($data->skills) {
            $job->skills()->attach($data->skills);
        }

        return JobData::from($job);
    }

    /**
     * Get all jobs.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return JobData::collect(Job::all());
    }

    /**
     * Get a job by its ID.
     *
     * @param int $id
     * @return JobData|null
     */
    public function findById(int $id): ?JobData
    {
        $job =  Job::with('skills')->findOrFail($id);

        return JobData::from($job);
    }

    /**
     * Update an existing job.
     *
     * @param int $id
     * @param UpdateJobData $data
     * @return JobData|null
     */
    public function update(int $id, UpdateJobData $data): ?JobData
    {
        $job = Job::find($id);
        if ($job) {
            $job->update([
                "title" => $data->title,
                "description" => $data->description,
                "budget" => $data->budget,
            ]);

            if ($data->skills) {
                $job->skills()->attach($data->skills);
            }

            return JobData::from($job);
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
     * @return JobData|null
     */
    public function removeSkills(int $id, array $data): ?JobData
    {
        $job = Job::find($id);
        if ($job) {

            if ($data['skills']) {
                $job->skills()->detach($data["skills"]);
            }

            return JobData::from($job);
        }

        return null;
    }
}