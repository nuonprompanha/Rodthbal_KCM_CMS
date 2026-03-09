<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class UserAccountController extends Controller
{
    /**
     * Display the user accounts page (active and pending users list).
     */
    public function index(): View
    {
        $users = User::with(['departments', 'permissions'])
            ->where('user_type', User::TYPE_AUTHENTICATED)
            ->where('is_suspended', false)
            ->orderBy('is_approved')
            ->orderBy('name')
            ->paginate(15);
        $departments = UserDepartment::orderBy('dept_name')->get();
        $permissions = UserPermission::orderBy('permission_name')->get();
        $approveUser = session('approve_user_id') ? User::find(session('approve_user_id')) : null;
        $modifyUser = session('modify_user_id') ? User::with(['departments', 'permissions'])->find(session('modify_user_id')) : null;

        return view('dashboard.user-accounts.active-user-accounts', compact('users', 'departments', 'permissions', 'approveUser', 'modifyUser'));
    }

    /**
     * Display the requested (pending approval) users list.
     */
    public function requestedUsers(): View
    {
        $requestedUsers = User::with(['departments', 'permissions'])
            ->where('is_approved', false)
            ->orderBy('name')
            ->paginate(15);
        $departments = UserDepartment::orderBy('dept_name')->get();
        $permissions = UserPermission::orderBy('permission_name')->get();
        $approveUser = session('approve_user_id') ? User::find(session('approve_user_id')) : null;
        $modifyUser = session('modify_user_id') ? User::with(['departments', 'permissions'])->find(session('modify_user_id')) : null;

        return view('dashboard.user-accounts.request-user-accounts', compact('requestedUsers', 'departments', 'permissions', 'approveUser', 'modifyUser'));
    }

    /**
     * Display the public users list (user_type = public, no dashboard access).
     */
    public function publicUsers(): View
    {
        $users = User::with(['departments', 'permissions'])
            ->where('user_type', User::TYPE_PUBLIC)
            ->orderBy('name')
            ->paginate(15);
        $departments = UserDepartment::orderBy('dept_name')->get();
        $permissions = UserPermission::orderBy('permission_name')->get();
        $approveUser = session('approve_user_id') ? User::find(session('approve_user_id')) : null;
        $modifyUser = session('modify_user_id') ? User::with(['departments', 'permissions'])->find(session('modify_user_id')) : null;

        return view('dashboard.user-accounts.public-user-accounts', compact('users', 'departments', 'permissions', 'approveUser', 'modifyUser'));
    }

    /**
     * Display the suspended users list.
     */
    public function suspendedUsers(): View
    {
        $suspendedUsers = User::with(['departments', 'permissions'])
            ->where('is_suspended', true)
            ->orderBy('name')
            ->paginate(15);
        $departments = UserDepartment::orderBy('dept_name')->get();
        $permissions = UserPermission::orderBy('permission_name')->get();
        $approveUser = session('approve_user_id') ? User::find(session('approve_user_id')) : null;
        $modifyUser = session('modify_user_id') ? User::with(['departments', 'permissions'])->find(session('modify_user_id')) : null;

        return view('dashboard.user-accounts.suspended-user-accounts', compact('suspendedUsers', 'departments', 'permissions', 'approveUser', 'modifyUser'));
    }

    /**
     * Store a newly created user (from modal). New users are not approved by default.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'         => ['nullable', 'string', 'max:30'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'address'       => ['nullable', 'string', 'max:500'],
            'user_type'     => ['required', 'in:'.User::TYPE_AUTHENTICATED.','.User::TYPE_PUBLIC],
        ]);

        User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'phone'         => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address'       => $validated['address'] ?? null,
            'is_approved'   => false,
            'user_type'     => $validated['user_type'] ?? User::TYPE_AUTHENTICATED,
        ]);

        return redirect()
            ->route('dashboard.user-accounts')
            ->with('status', 'User created successfully. They must be approved before they can log in.');
    }

    /**
     * Approve a user: set department and permissions, then mark as approved.
     */
    public function approve(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'user_department_id' => ['required', 'exists:user_departments,id'],
            'permissions'        => ['nullable', 'array'],
            'permissions.*'      => ['exists:user_permissions,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.user-accounts')
                ->withErrors($validator)
                ->with('approve_user_id', $user->id)
                ->withInput();
        }

        $validated = $validator->validated();
        $user->departments()->sync([$validated['user_department_id']]);
        $user->permissions()->sync($validated['permissions'] ?? []);
        $user->update([
            'is_approved' => true,
            'user_type'   => User::TYPE_AUTHENTICATED,
        ]);

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()
            ->route('dashboard.user-accounts')
            ->with('status', 'User approved successfully. A verification email has been sent so they can verify their address before accessing the dashboard.');
    }

    /**
     * Update a user's department and permissions (Modify).
     */
    public function modify(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'user_department_id' => ['required_if:user_type,'.User::TYPE_AUTHENTICATED, 'nullable', 'exists:user_departments,id'],
            'permissions'        => ['nullable', 'array'],
            'permissions.*'      => ['exists:user_permissions,id'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'date_of_birth'      => ['nullable', 'date', 'before:today'],
            'address'            => ['nullable', 'string', 'max:500'],
            'user_type'          => ['required', 'in:'.User::TYPE_AUTHENTICATED.','.User::TYPE_PUBLIC],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->with('modify_user_id', $user->id)
                ->withInput();
        }

        $validated = $validator->validated();
        if (! empty($validated['user_department_id'])) {
            $user->departments()->sync([$validated['user_department_id']]);
        } else {
            $user->departments()->sync([]);
        }
        $user->permissions()->sync($validated['permissions'] ?? []);
        $user->update([
            'phone'         => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address'       => $validated['address'] ?? null,
            'user_type'     => $validated['user_type'],
        ]);

        return redirect()
            ->back()
            ->with('status', 'User details and permissions updated successfully.');
    }

    /**
     * Suspend a user (set is_suspended = true).
     */
    public function suspend(User $user): RedirectResponse
    {
        $user->update(['is_suspended' => true]);

        return redirect()
            ->route('dashboard.user-accounts')
            ->with('status', 'User suspended successfully.');
    }

    /**
     * Restore a suspended user (set is_suspended = false). User becomes active/approved again.
     */
    public function restore(User $user): RedirectResponse
    {
        $user->update(['is_suspended' => false]);

        return redirect()
            ->route('dashboard.suspended-users')
            ->with('status', 'User restored successfully. They can log in again.');
    }
}
