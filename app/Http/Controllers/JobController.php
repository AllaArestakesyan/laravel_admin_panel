<?php

namespace App\Http\Controllers;

use App\Contracts\JobServiceInterface;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;

class JobController extends Controller
{
     /**
     * Inject the jobService into the controller.
     *
     * @param JobServiceInterface $jobService
     */
    public function __construct(private JobServiceInterface $jobService)
    {
    }

    /**
     * Create a new job.
     *
     * @param StoreJobRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreJobRequest $request)
    {
        $data = $request->all();
        $job = $this->jobService->create($data);
        return response()->json($job, 201);
    }

    /**
     * Get all jobs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $jobs = $this->jobService->findAll();
        return response()->json($jobs);
    }

    /**
     * Get a job by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $job = $this->jobService->findById($id);
        if ($job) {
            return response()->json($job);
        }
        return response()->json(['message' => 'Job not found'], 404);
    }

    /**
     * Update an existing job.
     *
     * @param UpdateJobRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateJobRequest $request, $id)
    {
        $data = $request->all();
        $job = $this->jobService->update($id, $data);
        if ($job) {
            return response()->json($job);
        }
        return response()->json(['message' => 'Job not found'], 404);
    }

    /**
     * Delete a job by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $success = $this->jobService->delete($id);
        if ($success) {
            return response()->json(['message' => 'Job deleted']);
        }
        return response()->json(['message' => 'Job not found'], 404);
    }
}
