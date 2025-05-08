<?php

namespace App\Http\Controllers\Api;

use App\Contracts\JobServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\JsonResponse;

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
     * Get all jobs.
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $jobs = $this->jobService->findAll();
        return response()->json($jobs);
    }

    /**
     * Get a job by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $job = $this->jobService->findById($id);
        if ($job) {
            return response()->json($job);
        }
        return response()->json(['message' => 'Job not found'], 404);
    }

}
