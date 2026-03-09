<?php

namespace App\Http\Controllers;

use App\Models\UserDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDepartmentController extends Controller
{
    /**
     * Display a listing of the user departments.
     */
    public function index(): View
    {
        $departments = UserDepartment::orderBy('dept_name', 'asc')->paginate(15);

        return view('dashboard.user-departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new user department.
     */
    public function create(): View
    {
        return view('dashboard.user-departments.create');
    }

    /**
     * Store a newly created user department in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255'],
            'dept_sub'  => ['nullable', 'string', 'max:255'],
        ]);

        UserDepartment::create($validated);

        return redirect()
            ->route('dashboard.user-departments.index')
            ->with('status', 'Department created successfully.');
    }

    /**
     * Display the specified user department.
     */
    public function show(UserDepartment $userDepartment): View
    {
        return view('dashboard.user-departments.show', compact('userDepartment'));
    }

    /**
     * Show the form for editing the specified user department.
     */
    public function edit(UserDepartment $userDepartment): View
    {
        return view('dashboard.user-departments.edit', compact('userDepartment'));
    }

    /**
     * Update the specified user department in storage.
     */
    public function update(Request $request, UserDepartment $userDepartment): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255'],
            'dept_sub'  => ['nullable', 'string', 'max:255'],
        ]);

        $userDepartment->update($validated);

        return redirect()
            ->route('dashboard.user-departments.index')
            ->with('status', 'Department updated successfully.');
    }

    /**
     * Remove the specified user department from storage.
     */
    public function destroy(UserDepartment $userDepartment): RedirectResponse
    {
        $userDepartment->delete();

        return redirect()
            ->route('dashboard.user-departments.index')
            ->with('status', 'Department deleted successfully.');
    }
}
