{{-- Photo Modal --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded shadow-sm">
            </div>
            <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- Create Staff Modal --}}
<div class="modal fade" id="createStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Staff</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="createStaffForm" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    {{-- Row 1: Names --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Staff Code</label>
                            <input type="text" name="staff_code" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    {{-- Row 2: Gender, Department, Status, Photo --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-select">
                                <option value="">-- Select --</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active">Active</option>
                                <option value="NoActive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" onchange="previewStaffPhoto(this)">
                        </div>
                    </div>

                    {{-- Row 3: Dates & Phone --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                    </div>

                    {{-- Row 4: Salary, Qualification, Specialization, License --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" step="0.01" name="salary" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Specialization</label>
                            <input type="text" name="specialization" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">License Number</label>
                            <input type="text" name="license_number" class="form-control">
                        </div>
                    </div>

                    {{-- Photo Preview --}}
                    <div class="mt-3" id="photoPreviewContainer"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>