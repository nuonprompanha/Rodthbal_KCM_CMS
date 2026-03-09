@extends('layouts.dashboard.admin_layouts')
@section('title', 'User Permissions | Dashboard | RODTHBAL KCN')
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
                        <h3 class="mb-0">User Permissions</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Permissions</li>
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
                        <h5 class="card-title m-0 p-0"><i class="fa-solid fa-key"></i> Permissions</h5>
                        <div class="card-tools m-0 p-0">
                            <button type="button" class="btn btn-primary btn-sm btn-flat" data-bs-toggle="modal"
                                data-bs-target="#createPermissionModal"><i class="fa-solid fa-plus"></i> Create
                                Permission</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Permission Name</th>
                                    <th>Permission Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $index => $perm)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $index }}</td>
                                        <td>{{ $perm->permission_name }}</td>
                                        <td>{{ $perm->permission_slug ?? '—' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-permission"
                                                data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                                data-id="{{ $perm->id }}"
                                                data-permission-name="{{ e($perm->permission_name) }}"
                                                data-permission-slug="{{ e($perm->permission_slug ?? '') }}"
                                                data-update-url="{{ route('dashboard.user-permissions.update', $perm) }}">Edit</button>
                                            <form action="{{ route('dashboard.user-permissions.destroy', $perm) }}"
                                                method="POST" class="d-inline delete-permission-form"
                                                data-permission-name="{{ e($perm->permission_name) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-danger btn-sm btn-delete-permission">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No permissions yet. Click
                                            "Create Permission" to add one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Permission Modal -->
    <div class="modal fade" id="createPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dashboard.user-permissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createPermissionModalLabel">Create Permission</h1>
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
                            <label for="create_permission_name" class="form-label">Permission Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('permission_name') is-invalid @enderror"
                                id="create_permission_name" name="permission_name" value="{{ old('permission_name') }}"
                                placeholder="Enter Permission Name" required>
                            @error('permission_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="create_permission_slug" class="form-label">Permission Slug <small
                                    class="text-muted">(auto: name, lowercase, spaces → .)</small></label>
                            <input type="text" class="form-control @error('permission_slug') is-invalid @enderror"
                                id="create_permission_slug" name="permission_slug" value="{{ old('permission_slug') }}"
                                placeholder="Auto-filled from name" readonly tabindex="-1">
                            @error('permission_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPermissionForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editPermissionModalLabel">Edit Permission</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_permission_name" class="form-label">Permission Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_permission_name" name="permission_name"
                                placeholder="Enter Permission Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_permission_slug" class="form-label">Permission Slug <small
                                    class="text-muted">(auto: name, lowercase, spaces → .)</small></label>
                            <input type="text" class="form-control" id="edit_permission_slug" name="permission_slug"
                                placeholder="Auto-filled from name" readonly tabindex="-1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('createPermissionModal'));
                modal.show();
            });
        </script>
    @endif
    <script>
        document.getElementById('create_permission_name')?.addEventListener('input', function() {
            var slug = document.getElementById('create_permission_slug');
            if (slug) slug.value = this.value.toLowerCase().replace(/\s+/g, '.');
        });

        document.querySelectorAll('.btn-edit-permission').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var form = document.getElementById('editPermissionForm');
                form.action = this.getAttribute('data-update-url');
                document.getElementById('edit_permission_name').value = this.getAttribute(
                    'data-permission-name') || '';
                document.getElementById('edit_permission_slug').value = this.getAttribute(
                    'data-permission-slug') || '';
            });
        });

        document.getElementById('edit_permission_name')?.addEventListener('input', function() {
            var slug = document.getElementById('edit_permission_slug');
            if (slug) slug.value = this.value.toLowerCase().replace(/\s+/g, '.');
        });
    </script>
@endsection
