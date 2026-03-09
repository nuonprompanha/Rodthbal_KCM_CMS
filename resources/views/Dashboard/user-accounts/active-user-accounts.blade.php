@extends('layouts.dashboard.admin_layouts')
@section('title', 'Users Accounts | Dashboard | RODTHBAL KCN')
@section('sidebar')
    @include('layouts.dashboard.admin_sidebar')
@endsection
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Users Accounts</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users Accounts</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0 p-0"><i class="fa-solid fa-list-ul"></i> Active User Accounts</h5>
                        <div class="card-tools m-0 p-0">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-bs-toggle="modal"
                                data-bs-target="#createUserModal"><i class="fa-solid fa-plus"></i> Add User</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="3%">No</th>
                                        <th class="text-center" width="7%">Name</th>
                                        <th class="text-center" width="7%">Email</th>
                                        <th class="text-center" width="6%">Contact</th>
                                        <th class="text-center" width="3%">Status</th>
                                        <th class="text-center" width="5%">User Type</th>
                                        <th class="text-center" width="5%">Department</th>
                                        <th class="text-center" width="18%">Permissions</th>
                                        <th class="text-center" width="12%">Last Login</th>
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td class="text-center align-middle">{{ $users->firstItem() + $index }}</td>
                                            <td class="align-middle">{{ $user->name }}</td>
                                            <td class="align-middle">{{ $user->email }}</td>
                                            <td class="align-middle">{{ $user->phone ?: '—' }}</td>
                                            <td class="align-middle text-center">
                                                @if ($user->is_approved)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($user->user_type === 'authenticated')
                                                    <span class="badge bg-primary">Authenticated</span>
                                                @else
                                                    <span class="badge bg-secondary">Public</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($user->departments->isNotEmpty())
                                                    {{ $user->departments->pluck('dept_name')->join(', ') }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($user->permissions->isNotEmpty())
                                                    {{ $user->permissions->pluck('permission_name')->join(', ') }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="align-middle small">
                                                @if ($user->last_login_at)
                                                    <div>{{ $user->last_login_at->format('d M Y H:i') }}</div>
                                                    @if ($user->last_login_ip || $user->last_login_browser || $user->last_login_location)
                                                        <div class="text-muted" style="font-size: 0.85em;">
                                                            {{ $user->last_login_ip ?? '—' }}
                                                            @if ($user->last_login_browser) · {{ $user->last_login_browser }}@endif
                                                            @if ($user->last_login_location) · {{ $user->last_login_location }}@endif
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if (!$user->is_approved)
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#approveUserModal"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ e($user->name) }}"
                                                        data-user-email="{{ e($user->email) }}">
                                                        <i class="fa-solid fa-check"></i> Approve
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-sm btn-modify-user"
                                                        data-bs-toggle="modal" data-bs-target="#modifyUserModal"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ e($user->name) }}"
                                                        data-user-email="{{ e($user->email) }}"
                                                        data-user-phone="{{ e($user->phone ?? '') }}"
                                                        data-user-date-of-birth="{{ $user->date_of_birth?->format('Y-m-d') ?? '' }}"
                                                        data-user-address="{{ e($user->address ?? '') }}"
                                                        data-user-type="{{ $user->user_type ?? 'public' }}"
                                                        data-department-id="{{ $user->departments->first()?->id }}"
                                                        data-permission-ids="{{ $user->permissions->pluck('id')->values()->toJson() }}">
                                                        <i class="fa-solid fa-pen-to-square"></i> Modify
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-suspend-user"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ e($user->name) }}"
                                                        data-user-email="{{ e($user->email) }}">
                                                        <i class="fa-solid fa-ban"></i> Suspend
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">No users yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('dashboard.user-accounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel"><i
                                class="fa-solid fa-user-plus me-2"></i>Create
                            User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="createUserName" class="form-label">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="createUserName" name="name" value="{{ old('name') }}" required
                                placeholder="Enter full name" autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserEmail" class="form-label">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="createUserEmail" name="email" value="{{ old('email') }}" required
                                placeholder="user@example.com" autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                id="createUserPhone" name="phone" value="{{ old('phone') }}"
                                placeholder="Phone number" autocomplete="tel">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserDob" class="form-label">Date of birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                id="createUserDob" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserAddress" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="createUserAddress" name="address"
                                rows="2" placeholder="Address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserPassword" class="form-label">Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="createUserPassword" name="password" required placeholder="Enter password"
                                autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="createUserType" class="form-label">User Type <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('user_type') is-invalid @enderror" id="createUserType"
                                name="user_type" required>
                                <option value="authenticated" @selected(old('user_type', 'authenticated') === 'authenticated')>Authenticated (Dashboard access)
                                </option>
                                <option value="public" @selected(old('user_type') === 'public')>Public (No dashboard access)</option>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label for="createUserPasswordConfirmation" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="createUserPasswordConfirmation"
                                name="password_confirmation" required placeholder="Confirm password"
                                autocomplete="new-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Create
                            User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approve User Modal -->
    <div class="modal fade" id="approveUserModal" tabindex="-1" aria-labelledby="approveUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="approveUserForm" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveUserModalLabel"><i
                                class="fa-solid fa-user-check me-2"></i>Approve User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">
                            <strong id="approveUserName"></strong><br>
                            <span class="text-muted small" id="approveUserEmail"></span>
                        </p>
                        @if ($errors->has('user_department_id') || $errors->has('permissions'))
                            <div class="alert alert-danger py-2 mb-3">
                                <ul class="mb-0 small">
                                    @foreach ($errors->get('user_department_id') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('permissions') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('permissions.*') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="approveDepartment" class="form-label">Department <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('user_department_id') is-invalid @enderror"
                                id="approveDepartment" name="user_department_id" required>
                                <option value="">— Select Department —</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}" @selected(old('user_department_id') == $dept->id)>
                                        {{ $dept->dept_name }}{{ $dept->dept_sub ? ' — ' . $dept->dept_sub : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Permissions</label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @php $oldPerms = (array) old('permissions', []); @endphp
                                @forelse($permissions as $perm)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $perm->id }}" id="perm_{{ $perm->id }}"
                                            @checked(in_array($perm->id, $oldPerms))>
                                        <label class="form-check-label"
                                            for="perm_{{ $perm->id }}">{{ $perm->permission_name }}</label>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No permissions defined. Add some in User Permissions.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-check me-1"></i> Approve
                            User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modify User Modal (Department & Permissions) -->
    <div class="modal fade" id="modifyUserModal" tabindex="-1" aria-labelledby="modifyUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="modifyUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifyUserModalLabel"><i
                                class="fa-solid fa-pen-to-square me-2"></i>Modify User Details & Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">
                            <strong id="modifyUserName"></strong><br>
                            <span class="text-muted small" id="modifyUserEmail"></span>
                        </p>
                        @if ($modifyUser && $errors->any())
                            <div class="alert alert-danger py-2 mb-3">
                                <ul class="mb-0 small">
                                    @foreach ($errors->get('user_department_id') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('permissions') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('permissions.*') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('phone') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('date_of_birth') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('address') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                    @foreach ($errors->get('user_type') as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="modifyUserType" class="form-label">User Type <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="modifyUserType" name="user_type" required>
                                <option value="authenticated" @selected(old('user_type', $modifyUser?->user_type) === 'authenticated')>Authenticated (Dashboard access)
                                </option>
                                <option value="public" @selected(old('user_type', $modifyUser?->user_type) === 'public')>Public (No dashboard access)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modifyPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="modifyPhone" name="phone"
                                placeholder="Phone number" value="{{ old('phone', $modifyUser?->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label for="modifyDob" class="form-label">Date of birth</label>
                            <input type="date" class="form-control" id="modifyDob" name="date_of_birth"
                                value="{{ old('date_of_birth', $modifyUser?->date_of_birth?->format('Y-m-d')) }}">
                        </div>
                        <div class="mb-3">
                            <label for="modifyAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="modifyAddress" name="address" rows="2" placeholder="Address">{{ old('address', $modifyUser?->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="modifyDepartment" class="form-label">Department <span class="text-danger"
                                    id="modifyDepartmentRequired">*</span></label>
                            <select class="form-select" id="modifyDepartment" name="user_department_id">
                                <option value="">— Select Department —</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        @if (strtolower($dept->dept_name) === 'administrator') data-is-admin="1" @endif
                                        @if (strtolower($dept->dept_name) === 'subscript') data-is-subscript="1" @endif>
                                        {{ $dept->dept_name }}{{ $dept->dept_sub ? ' — ' . $dept->dept_sub : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Permissions</label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @forelse($permissions as $perm)
                                    <div class="form-check">
                                        <input class="form-check-input modify-perm-cb" type="checkbox"
                                            name="permissions[]" value="{{ $perm->id }}"
                                            id="modify_perm_{{ $perm->id }}">
                                        <label class="form-check-label"
                                            for="modify_perm_{{ $perm->id }}">{{ $perm->permission_name }}</label>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No permissions defined. Add some in User Permissions.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-save me-1"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden form for suspend (submitted via JS after SweetAlert2 confirm) -->
    <form id="suspendUserForm" method="POST" action="" class="d-none"
        data-action-template="{{ route('dashboard.user-accounts.suspend', ['user' => '__ID__']) }}">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Suspend user: SweetAlert2 confirm then submit form
            var suspendForm = document.getElementById('suspendUserForm');
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 (Swal) is not loaded. Suspend confirm will not work.');
            }
            document.querySelectorAll('.btn-suspend-user').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var userId = this.getAttribute('data-user-id');
                    var userName = this.getAttribute('data-user-name') || 'this user';
                    var userEmail = this.getAttribute('data-user-email') || '';
                    var actionTemplate = suspendForm && suspendForm.getAttribute(
                        'data-action-template');
                    var actionUrl = actionTemplate ? actionTemplate.replace('__ID__', userId) :
                        '{{ url('dashboard/user-accounts') }}/' + userId + '/suspend';

                    Swal.fire({
                        title: 'Suspend user?',
                        html: 'You are about to suspend <strong>' + userName + '</strong>' +
                            (userEmail ? '<br><span class="text-muted small">' + userEmail +
                                '</span>' : '') +
                            '<br><br>They will not be able to log in until unsuspended.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, suspend'
                    }).then(function(result) {
                        if (result.isConfirmed && suspendForm) {
                            suspendForm.action = actionUrl;
                            suspendForm.submit();
                        }
                    });
                });
            });

            var approveModalEl = document.getElementById('approveUserModal');
            if (approveModalEl) {
                approveModalEl.addEventListener('show.bs.modal', function(event) {
                    var btn = event.relatedTarget;
                    var form = document.getElementById('approveUserForm');
                    if (btn && btn.dataset.userId) {
                        form.action = '{{ url('dashboard/user-accounts') }}/' + btn.dataset.userId +
                            '/approve';
                        document.getElementById('approveUserName').textContent = btn.dataset.userName || '';
                        document.getElementById('approveUserEmail').textContent = btn.dataset.userEmail ||
                            '';
                        if (!document.body.contains(document.querySelector('[data-approve-reopen]'))) {
                            form.querySelectorAll('input[name="permissions[]"]').forEach(function(cb) {
                                cb.checked = false;
                            });
                            form.querySelector('#approveDepartment').value = '';
                        }
                    }
                });
            }

            function applyModifyAdminPermissions() {
                var deptSelect = document.getElementById('modifyDepartment');
                if (!deptSelect) return;
                var opt = deptSelect.options[deptSelect.selectedIndex];
                var isAdmin = opt && opt.getAttribute('data-is-admin') === '1';
                var isSubscript = opt && opt.getAttribute('data-is-subscript') === '1';
                document.querySelectorAll('#modifyUserForm .modify-perm-cb').forEach(function(cb) {
                    if (isSubscript) cb.checked = false;
                    else if (isAdmin) cb.checked = true;
                });
            }
            var modifyModalEl = document.getElementById('modifyUserModal');
            if (modifyModalEl) {
                modifyModalEl.addEventListener('show.bs.modal', function(event) {
                    var btn = event.relatedTarget;
                    var form = document.getElementById('modifyUserForm');
                    if (btn && btn.dataset.userId) {
                        form.action = '{{ url('dashboard/user-accounts') }}/' + btn.dataset.userId +
                            '/modify';
                        document.getElementById('modifyUserName').textContent = btn.dataset.userName || '';
                        document.getElementById('modifyUserEmail').textContent = btn.dataset.userEmail ||
                            '';
                        var userTypeEl = document.getElementById('modifyUserType');
                        if (userTypeEl && btn.dataset.userType) userTypeEl.value = btn.dataset.userType;
                        var phoneEl = document.getElementById('modifyPhone');
                        if (phoneEl) phoneEl.value = btn.dataset.userPhone || '';
                        var dobEl = document.getElementById('modifyDob');
                        if (dobEl) dobEl.value = btn.dataset.userDateOfBirth || '';
                        var addrEl = document.getElementById('modifyAddress');
                        if (addrEl) addrEl.value = btn.dataset.userAddress || '';
                        var deptSelect = document.getElementById('modifyDepartment');
                        if (deptSelect && btn.dataset.departmentId) deptSelect.value = btn.dataset
                            .departmentId;
                        else if (deptSelect) deptSelect.value = '';
                        var permIds = [];
                        try {
                            permIds = JSON.parse(btn.dataset.permissionIds || '[]');
                        } catch (e) {}
                        form.querySelectorAll('.modify-perm-cb').forEach(function(cb) {
                            cb.checked = permIds.indexOf(parseInt(cb.value, 10)) !== -1;
                        });
                        applyModifyAdminPermissions();
                    }
                });
            }
            var modifyDeptSelect = document.getElementById('modifyDepartment');
            if (modifyDeptSelect) {
                modifyDeptSelect.addEventListener('change', applyModifyAdminPermissions);
            }
            @if ($approveUser && $errors->any())
                (function() {
                    var form = document.getElementById('approveUserForm');
                    form.action = '{{ route('dashboard.user-accounts.approve', $approveUser) }}';
                    document.getElementById('approveUserName').textContent = {!! json_encode($approveUser->name) !!};
                    document.getElementById('approveUserEmail').textContent = {!! json_encode($approveUser->email) !!};
                    document.body.setAttribute('data-approve-reopen', '1');
                    new bootstrap.Modal(document.getElementById('approveUserModal')).show();
                })();
            @endif
            @if ($modifyUser && $errors->any())
                (function() {
                    var form = document.getElementById('modifyUserForm');
                    form.action = '{{ route('dashboard.user-accounts.modify', $modifyUser) }}';
                    document.getElementById('modifyUserName').textContent = {!! json_encode($modifyUser->name) !!};
                    document.getElementById('modifyUserEmail').textContent = {!! json_encode($modifyUser->email) !!};
                    var phoneEl = document.getElementById('modifyPhone');
                    if (phoneEl) phoneEl.value = {!! json_encode(old('phone', $modifyUser->phone)) !!} || '';
                    var dobEl = document.getElementById('modifyDob');
                    if (dobEl) dobEl.value = {!! json_encode(old('date_of_birth', $modifyUser->date_of_birth?->format('Y-m-d'))) !!} || '';
                    var addrEl = document.getElementById('modifyAddress');
                    if (addrEl) addrEl.value = {!! json_encode(old('address', $modifyUser->address)) !!} || '';
                    var userTypeEl = document.getElementById('modifyUserType');
                    if (userTypeEl) userTypeEl.value = {!! json_encode(old('user_type', $modifyUser->user_type)) !!} || 'public';
                    var deptSelect = document.getElementById('modifyDepartment');
                    var oldDept = {!! json_encode(old('user_department_id')) !!};
                    var firstDeptId = {!! json_encode($modifyUser->departments->first()?->id) !!};
                    if (deptSelect) deptSelect.value = oldDept || firstDeptId || '';
                    var oldPerms = {!! json_encode((array) old('permissions', [])) !!};
                    form.querySelectorAll('.modify-perm-cb').forEach(function(cb) {
                        cb.checked = oldPerms.indexOf(parseInt(cb.value, 10)) !== -1 || oldPerms
                            .indexOf(cb.value) !== -1;
                    });
                    applyModifyAdminPermissions();
                    new bootstrap.Modal(document.getElementById('modifyUserModal')).show();
                })();
            @endif
            @if ($errors->any() && !$errors->has('user_department_id') && !$errors->has('permissions'))
                var createModal = new bootstrap.Modal(document.getElementById('createUserModal'));
                createModal.show();
            @endif
        });
    </script>
@endsection
