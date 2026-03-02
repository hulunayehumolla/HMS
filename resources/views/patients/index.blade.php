@extends('layouts.app')

@section('content')
<style>
    .form-check-input{
        border-color: darkblue;

    }
   .form-control,.form-select {
    border: none;              /* Remove all borders */
    border-bottom: 2px solid skyblue;  /* Add only bottom border */
    border-radius: 0;          /* Remove rounded corners */
    box-shadow: none;          /* Remove Bootstrap shadow */
}

.form-control:focus,
.form-select:focus {
    border-bottom: 2px solid #0d6efd; /* Change color on focus (optional) */
    box-shadow: none;
    outline: none;
}

</style>
<div class="container">

    <h4 class="fw-bold mb-4">
        <i class="fa-solid fa-user-injured me-2 text-primary"></i>
        Patients Management
    </h4>

    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs mb-3" id="patientTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link {{ !$errors->any() ? 'active' : '' }}"
                    id="list-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#list"
                    type="button">
                <i class="fa fa-list me-1"></i>
                Patient List
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link {{ $errors->any() ? 'active' : '' }}"
                    id="add-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#add"
                    type="button">
                <i class="fa fa-user-plus me-1"></i>
                Add New Patient
            </button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- ================= PATIENT LIST TAB ================= --}}
        <div class="tab-pane fade {{ !$errors->any() ? 'show active' : '' }}" id="list">

            <form method="GET" class="mb-3 row g-2">
                {{-- Live Search --}}
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name, ID, phone..."
                           value="{{ $filters['search'] ?? '' }}">
                </div>

                {{-- Gender --}}
                <div class="col-md-2">
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="male" {{ ($filters['gender'] ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ ($filters['gender'] ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                {{-- Insurance --}}
                <div class="col-md-2">
                    <select name="is_insurance_user" class="form-select">
                        <option value="">All Insurance</option>
                        <option value="1" {{ ($filters['is_insurance_user'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ ($filters['is_insurance_user'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                {{-- Referred --}}
                <div class="col-md-2">
                    <select name="is_referred" class="form-select">
                        <option value="">All Referred</option>
                        <option value="1" {{ ($filters['is_referred'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ ($filters['is_referred'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                {{-- Blood Type --}}
                <div class="col-md-2">
                    <label class="form-label visually-hidden">Blood Type</label>
                    <select name="blood_type" class="form-select">
                        <option value="" {{ empty($filters['blood_type'] ?? '') ? 'selected' : '' }}>- Select -</option>
                        @php
                            $bloodTypes = ['A+', 'A', 'A-', 'AB', 'B+', 'B', 'O+', 'O-', 'O'];
                            $selectedBlood = $filters['blood_type'] ?? '';
                        @endphp
                        @foreach($bloodTypes as $type)
                            <option value="{{ $type }}" {{ $selectedBlood == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Patient ID</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Insurance</th>
                                <th>Referred</th>
                                <th>Blood Type</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $patient->patient_id }}</td>
                                    <td>{{ $patient->full_name }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($patient->gender) }}</span></td>
                                    <td>{{ $patient->calculated_age ?? '-' }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->is_insurance_user ? 'Yes' : 'No' }}</td>
                                    <td>{{ $patient->is_referred ? 'Yes' : 'No' }}</td>
                                    <td>{{ $patient->blood_type ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('patients.edit',$patient) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('patients.destroy',$patient) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this patient?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No Patients Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $patients->withQueryString()->links() }}
                </div>
            </div>
        </div>

        {{-- ================= ADD PATIENT TAB ================= --}}
        <div class="tab-pane fade {{ $errors->any() ? 'show active' : '' }}" id="add">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                                {{-- First Name (Required) --}}
                                <div class="col-md-4">
                                   
                                    <input type="text" name="first_name"
                                           value="{{ old('first_name') }}"
                                           required
                                           class="form-control @error('first_name') is-invalid @enderror">
                                            <label class="form-label">First Name *</label>
                                </div>

                                {{-- Middle Name (Required based on migration) --}}
                                <div class="col-md-4">
                                  
                                    <input type="text" name="middle_name"
                                           value="{{ old('middle_name') }}"
                                           required
                                           class="form-control @error('middle_name') is-invalid @enderror">
                                             <label class="form-label">Middle Name *</label>
                                </div>

                                {{-- Last Name (Optional) --}}
                                <div class="col-md-4">
                                   
                                    <input type="text" name="last_name"
                                           value="{{ old('last_name') }}"
                                           class="form-control">
                                            <label class="form-label">Last Name</label>
                                </div>

                                {{-- Gender (Required) --}}
                                <div class="col-md-3">
                                    <select name="gender" required class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>

                                    <label class="form-label">Gender *</label>
                                </div>

                                {{-- Date of Birth (Optional) --}}
                                
                                    <div class="col-md-3">
                                        <input type="date" 
                                               id="date_of_birth"
                                               name="date_of_birth"
                                               value="{{ old('date_of_birth') }}"
                                               class="form-control">

                                        <label class="form-label">Date of Birth</label>
                                    </div>

                                     {{-- Age (Required - missing before) --}}
                                    <div class="col-md-3">
                                        <input type="number" 
                                               id="age" name="age"
                                               value="{{ old('age') }}"
                                               required  ="0"  
                                               class="form-control @error('age') is-invalid @enderror">

                                        <label class="form-label">Age *</label>
                                       </div>

                                {{-- Phone (Optional) --}}
                                <div class="col-md-3">
                                    <input type="text" name="phone"
                                           value="{{ old('phone') }}"
                                           class="form-control">  
                                    <label class="form-label">Phone</label>
                                </div>

                                {{-- Email (Optional) --}}
                                <div class="col-md-3">
                                    <input type="email" name="email"
                                           value="{{ old('email') }}"
                                           class="form-control">
                                    <label class="form-label">Email</label>
                                </div>

                                {{-- Blood Type (Optional) --}}
                                <div class="col-md-3">
                                    <select name="blood_type" class="form-select">
                                        <option value="">- Select -</option>
                                        @php
                                            $bloodTypes = ['A+', 'A-', 'AB+', 'AB-', 'B+', 'B-', 'O+', 'O-'];
                                        @endphp
                                        @foreach($bloodTypes as $type)
                                            <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label">Blood Type</label>
                                </div>

                                {{-- Address Fields (Optional) --}}
                                <div class="col-md-4 position-relative">

                                    <input type="text"
                                           id="search-country"
                                           class="form-control"
                                           placeholder="Search country..."
                                           value="{{ old('country') }}"
                                           autocomplete="off">
                                    <label class="form-label">Country</label>

                                    <input type="hidden"
                                           name="country"
                                           id="selected-country"
                                           value="{{ old('country') }}">

                                    <div id="country-list"
                                         class="list-group position-absolute w-100"
                                         style="z-index:1000; max-height:200px; overflow-y:auto; display:none;">
                                    </div>
                                </div>

                               <div class="col-md-4">
                                    <select id="region" class="form-select" name="region">
                                        <option value="">Select Region</option>
                                    </select>

                                    <label class="form-label">Region</label>
                                </div>

                                <div class="col-md-4">
                                    <select id="zone" name="zone" class="form-select">
                                        <option value="">Select Zone</option>
                                    </select>

                                    <label class="form-label">Zone</label>
                                </div>

                                <div class="col-md-4">
                                    <select id="woreda" name="woreda" class="form-select">
                                        <option value="">Select Woreda</option>
                                    </select>

                                    <label class="form-label">Woreda</label>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="kebele"
                                           value="{{ old('kebele') }}"
                                           class="form-control">

                                    <label class="form-label">Kebele</label>
                                </div>

                                {{-- Checkboxes --}}
                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input type="checkbox"
                                               id="is_referred"
                                               name="is_referred"
                                               value="1"
                                               {{ old('is_referred') ? 'checked' : '' }}
                                               class="form-check-input">
                                        <label class="form-check-label">Referred Patient</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input type="checkbox"
                                               name="is_insurance_user"
                                               value="1"
                                               {{ old('is_insurance_user') ? 'checked' : '' }}
                                               class="form-check-input">
                                        <label class="form-check-label">Insurance User</label>
                                    </div>
                                </div>

                                {{-- Optional --}}
                                <div class="col-md-6" id="referred_from_wrapper"
                                     style="{{ old('is_referred') ? '' : 'display:none;' }}">
                                    <input type="text"
                                           name="referred_from"
                                           value="{{ old('referred_from') }}"
                                           class="form-control">
                                    <label class="form-label">Referred From</label>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="emergency_contact_name"
                                           value="{{ old('emergency_contact_name') }}"
                                           class="form-control">
                                    <label class="form-label">Emergency Contact Name</label>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone') }}"
                                           class="form-control">

                                    <label class="form-label">Emergency Contact Phone</label>
                                </div>

                              <div class="col-12">
                                <button class="btn btn-success">
                                    <i class="fa fa-save me-1"></i>
                                    Register Patient
                                </button>
                            </div>

                          </div>
                        </form>

                </div>
            </div>
        </div>

        <!-- end of add New Petient -->

    </div>
</div>

<script>

/*date ristriction*/
document.addEventListener("DOMContentLoaded", function () {

    const dobInput = document.getElementById("date_of_birth");
    const ageInput = document.getElementById("age");

    // Prevent future dates
    const today = new Date().toISOString().split("T")[0];
    dobInput.setAttribute("max", today);

    dobInput.addEventListener("change", function () {
        const dob = new Date(this.value);
        const todayDate = new Date();

        let age = todayDate.getFullYear() - dob.getFullYear();
        const monthDiff = todayDate.getMonth() - dob.getMonth();

        // Adjust age if birthday hasn't happened yet this year
        if (monthDiff < 0 || 
            (monthDiff === 0 && todayDate.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age >= 0 ? age : '';
    });

});


/*<!-- selct country for student and parrent  -->*/
document.addEventListener('DOMContentLoaded', function () {

    /* ================= COUNTRIES SEARCH ================= */
    const countries = @json($countries);
    const searchInput = document.getElementById('search-country');
    const countryList = document.getElementById('country-list');
    const hiddenInput = document.getElementById('selected-country');

    function populateCountries(items) {
        countryList.innerHTML = '';
        items.forEach(country => {
            const div = document.createElement('div');
            div.classList.add('list-group-item','list-group-item-action');
            div.textContent = country.name;

            div.addEventListener('click', function () {
                searchInput.value = country.name;
                hiddenInput.value = country.name;
                countryList.style.display = 'none';
            });

            countryList.appendChild(div);
        });
    }

    searchInput.addEventListener('focus', function () {
        countryList.style.display = 'block';
        populateCountries(countries);
    });

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const filtered = countries.filter(c =>
            c.name.toLowerCase().includes(query)
        );
        populateCountries(filtered);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) &&
            !countryList.contains(e.target)) {
            countryList.style.display = 'none';
        }
    });

    /* ================= ETHIOPIAN ADMIN ================= */

    const ethiopia = @json($ethiopian_admins);
    const regionSelect = document.getElementById('region');
    const zoneSelect = document.getElementById('zone');
    const woredaSelect = document.getElementById('woreda');

    function populateRegions() {
        ethiopia.regions.forEach(region => {
            const option = document.createElement('option');
            option.value = region.name;
            option.textContent = region.name;
            regionSelect.appendChild(option);
        });
    }

    regionSelect.addEventListener('change', function () {
        zoneSelect.innerHTML = '<option value="">Select Zone</option>';
        woredaSelect.innerHTML = '<option value="">Select Woreda</option>';

        const selectedRegion = ethiopia.regions.find(r => r.name === this.value);

        if (selectedRegion) {
            selectedRegion.zones.forEach(zone => {
                const option = document.createElement('option');
                option.value = zone.name;
                option.textContent = zone.name;
                zoneSelect.appendChild(option);
            });
        }
    });

    zoneSelect.addEventListener('change', function () {
        woredaSelect.innerHTML = '<option value="">Select Woreda</option>';

        const selectedRegion = ethiopia.regions.find(r => r.name === regionSelect.value);
        const selectedZone = selectedRegion?.zones.find(z => z.name === this.value);

        if (selectedZone) {
            selectedZone.woredas.forEach(woreda => {
                const option = document.createElement('option');
                option.value = woreda;
                option.textContent = woreda;
                woredaSelect.appendChild(option);
            });
        }
    });

    populateRegions();



  
});


    /* ================= REFERRED TOGGLE ================= */

document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById('is_referred');
    const referredField = document.getElementById('referred_from_wrapper');

    function toggleReferredField() {
        if (checkbox.checked) {
            referredField.style.display = 'block';
        } else {
            referredField.style.display = 'none';
            referredField.querySelector('input').value = '';
        }
    }

    checkbox.addEventListener('change', toggleReferredField);
});
</script>

@endsection