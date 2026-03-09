@extends('layouts.dashboard.admin_layouts')
@section('title', 'User Departments | Dashboard | RODTHBAL KCN')
@section('sidebar')
    @include('layouts.dashboard.admin_sidebar')
@endsection
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">User Departments</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Departments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0 p-0"><i class="fa-solid fa-building"></i> Departments</h5>
                        <div class="card-tools m-0 p-0">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-bs-toggle="modal"
                                data-bs-target="#createDeptModal"><i class="fa-solid fa-plus"></i> Create Dept</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dept Name</th>
                                        <th>Dept Sub</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($departments as $index => $dept)
                                        <tr>
                                            <td>{{ $departments->firstItem() + $index }}</td>
                                            <td>{{ $dept->dept_name }}</td>
                                            <td>{{ $dept->dept_sub ?? '—' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm btn-edit-dept"
                                                    data-bs-toggle="modal" data-bs-target="#editDeptModal"
                                                    data-id="{{ $dept->id }}"
                                                    data-dept-name="{{ e($dept->dept_name) }}"
                                                    data-dept-sub="{{ e($dept->dept_sub ?? '') }}"
                                                    data-update-url="{{ route('dashboard.user-departments.update', $dept) }}">Edit</button>
                                                <form action="{{ route('dashboard.user-departments.destroy', $dept) }}"
                                                    method="POST" class="d-inline delete-department-form"
                                                    data-dept-name="{{ e($dept->dept_name) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-dept">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No departments yet. Click "Create Dept" to add one.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($departments->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $departments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Dept Modal -->
    <div class="modal fade" id="createDeptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createDeptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dashboard.user-departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createDeptModalLabel">Create Dept</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="create_dept_name" class="form-label">Dept Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('dept_name') is-invalid @enderror"
                                id="create_dept_name" name="dept_name" value="{{ old('dept_name') }}"
                                placeholder="Enter Dept Name" required>
                            @error('dept_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="create_dept_sub" class="form-label">Dept Sub</label>
                            <input type="text" class="form-control @error('dept_sub') is-invalid @enderror"
                                id="create_dept_sub" name="dept_sub" value="{{ old('dept_sub') }}"
                                placeholder="Enter Dept Sub (optional)">
                            @error('dept_sub')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Dept</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Dept Modal -->
    <div class="modal fade" id="editDeptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editDeptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editDeptForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editDeptModalLabel">Edit Dept</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_dept_name" class="form-label">Dept Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_dept_name" name="dept_name"
                                placeholder="Enter Dept Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_dept_sub" class="form-label">Dept Sub</label>
                            <input type="text" class="form-control" id="edit_dept_sub" name="dept_sub"
                                placeholder="Enter Dept Sub (optional)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Dept</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('createDeptModal'));
                modal.show();
            });
        </script>
    @endif
    <script>
        document.getElementById('create_dept_name')?.addEventListener('input', function() {
            var sub = document.getElementById('create_dept_sub');
            if (sub) sub.value = this.value.toLowerCase().replace(/\s+/g, '-');
        });

        document.querySelectorAll('.btn-edit-dept').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var form = document.getElementById('editDeptForm');
                form.action = this.getAttribute('data-update-url');
                document.getElementById('edit_dept_name').value = this.getAttribute('data-dept-name') || '';
                document.getElementById('edit_dept_sub').value = this.getAttribute('data-dept-sub') || '';
            });
        });

        document.getElementById('edit_dept_name')?.addEventListener('input', function() {
            var sub = document.getElementById('edit_dept_sub');
            if (sub) sub.value = this.value.toLowerCase().replace(/\s+/g, '-');
        });
    </script>
@endsection
