<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the user permissions.
     */
    public function index(): View
    {
        $permissions = UserPermission::orderBy('permission_name', 'asc')->paginate(15);

        return view('dashboard.user-permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new user permission.
     */
    public function create(): View
    {
        return view('dashboard.user-permissions.create');
    }

    /**
     * Store a newly created user permission in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'permission_name' => ['required', 'string', 'max:255'],
            'permission_slug' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['permission_slug'] = strtolower(preg_replace('/\s+/', '.', $validated['permission_name']));

        UserPermission::create($validated);

        return redirect()
            ->route('dashboard.user-permissions.index')
            ->with('status', 'Permission created successfully.');
    }

    /**
     * Display the specified user permission.
     */
    public function show(UserPermission $userPermission): View
    {
        return view('dashboard.user-permissions.show', compact('userPermission'));
    }

    /**
     * Show the form for editing the specified user permission.
     */
    public function edit(UserPermission $userPermission): View
    {
        return view('dashboard.user-permissions.edit', compact('userPermission'));
    }

    /**
     * Update the specified user permission in storage.
     */
    public function update(Request $request, UserPermission $userPermission): RedirectResponse
    {
        $validated = $request->validate([
            'permission_name' => ['required', 'string', 'max:255'],
            'permission_slug' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['permission_slug'] = strtolower(preg_replace('/\s+/', '.', $validated['permission_name']));

        $userPermission->update($validated);

        return redirect()
            ->route('dashboard.user-permissions.index')
            ->with('status', 'Permission updated successfully.');
    }

    /**
     * Remove the specified user permission from storage.
     */
    public function destroy(UserPermission $userPermission): RedirectResponse
    {
        $userPermission->delete();

        return redirect()
            ->route('dashboard.user-permissions.index')
            ->with('status', 'Permission deleted successfully.');
    }
}
