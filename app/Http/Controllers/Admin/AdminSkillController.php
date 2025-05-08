<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\SkillServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminSkillController extends Controller
{
    /**
     * Inject the skillService into the controller.
     *
     * @param SkillServiceInterface $skillService
     */
    public function __construct(private SkillServiceInterface $skillService)
    {
    }

    /**
     * Summary of create
     * 
     * @return View
     */
    public function create(): View
    {
        return view('admin.skillCreate');
    }


    /**
     * Summary of index
     * 
     * @return View
     */
    public function index(): View
    {
        $skills = $this->skillService->findAll();
        return view('admin.skills', compact('skills'));
    }

    /**
     * Summary of edit
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $skill = $this->skillService->findById($id);

        return view('admin.skillEdit', compact('skill'));
    }

    /**
     * Create a new skill.
     *
     * @param StoreSkillRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSkillRequest $request): RedirectResponse
    {
        $data = $request->all();
        $skill = $this->skillService->create($data);

        if ($skill) {

            return redirect()->route('admin.skills')->with('success', 'Skills create successfully.');
        }

        return redirect()->route('admin.skills')->with('error', 'Failed to create skill.');
    }

       /**
     * Summary of update
     * 
     * @param UpdateSkillRequest $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(UpdateSkillRequest $request, $id): RedirectResponse
    {
        $data = $request->all();
        $skill = $this->skillService->update($id, $data);

        if ($skill) {

            return redirect()->route('admin.skills')->with('success', 'Skill updated successfully.');
        }

        return redirect()->route('admin.skills')->with('error', 'Failed to update skill.');
    }

    /**
     * Summary of destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $success = $this->skillService->delete($id);

        if (!$success) {
            return redirect()->route('admin.skills')->with('error', 'Skill not found.');
        }

        return redirect()->route('admin.skills')->with('success', 'Skill deleted successfully.');
    }
}
