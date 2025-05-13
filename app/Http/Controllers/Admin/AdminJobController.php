<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\JobServiceInterface;
use App\Contracts\SkillServiceInterface;
use App\Data\StoreJobData;
use App\Data\UpdateJobData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RemoveJobSkillRequest;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;

class AdminJobController extends Controller
{
    /**
     * Summary of __construct
     * 
     * @param \App\Contracts\JobServiceInterface $jobService
     * @param \App\Contracts\SkillServiceInterface $skillService
     */
    public function __construct(
        private JobServiceInterface $jobService,
        private SkillServiceInterface $skillService,
    ) {
    }

    /**
     * Summary of create
     * 
     * @return View
     */
    public function create(): View
    {
        $skills = $this->skillService->findAll();

        return view('admin.jobCreate', compact('skills'));
    }


    /**
     * Summary of index
     * 
     * @return View
     */
    public function index(): View
    {
        $jobs = $this->jobService->findAll();
        return view('admin.jobs', compact('jobs'));
    }

    /**
     * Summary of edit
     * 
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {

            $job = $this->jobService->findById($id);
            $skills = $this->skillService->findAll();

            return view('admin.jobEdit', compact('job', 'skills'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.jobs')->with('error', 'Failed to create job.');
        }
    }

    /**
     * Create a new job.
     *
     * @param StoreJobRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobRequest $request): RedirectResponse
    {
        $data = StoreJobData::from($request->validated());
        $job = $this->jobService->create($data, $request->user()->id);

        if ($job) {

            return redirect()->route('admin.jobs')->with('success', 'Job create successfully.');
        }

        return redirect()->route('admin.jobs')->with('error', 'Failed to create job.');
    }

    /**
     * Summary of update
     * 
     * @param UpdateJobRequest $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(UpdateJobRequest $request, int $id): RedirectResponse
    {
        $data = UpdateJobData::from($request->validated());
        $job = $this->jobService->update($id, $data);

        if ($job) {

            return redirect()->route('admin.jobs')->with('success', 'Job updated successfully.');
        }

        return redirect()->route('admin.jobs')->with('error', 'Failed to update job.');
    }

    /**
     * Summary of destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $success = $this->jobService->delete($id);

        if (!$success) {
            return redirect()->route('admin.jobs')->with('error', 'Job not found.');
        }

        return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully.');
    }


    public function removeSkills(RemoveJobSkillRequest $request, int $id)
    {
        $data = $request->all();
        $job = $this->jobService->removeSkills($id, $data);

        if ($job) {

            return redirect()->route('admin.jobs')->with('success', 'Job updated successfully.');
        }

        return redirect()->route('admin.jobs')->with('error', 'Failed to update job.');

    }
}
