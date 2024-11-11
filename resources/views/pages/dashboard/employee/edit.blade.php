@extends('layouts.dashboard')

@section('title', 'Edit Data Kelas Aset')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.employee.update', $asset->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company_id">Perusahaan</label>
                            <select name="company_id" class="form-control" id="company_id">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $asset->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="project_id">Proyek</label>
                            <select name="project_id" class="form-control" id="project_id">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $asset->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" class="form-control" id="department_id">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ $asset->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Kelas Aset" value="{{ $asset->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Get the company and project select elements
        const companySelect = document.getElementById('company_id');
        const projectSelect = document.getElementById('project_id');

        // Add an event listener to the company select
        companySelect.addEventListener('change', function() {
            // Get the selected company ID
            const selectedCompanyId = this.value;

            // Clear the project select options
            projectSelect.innerHTML = '';

            // Check if a company is selected
            if (selectedCompanyId) {
                // Filter the projects based on the selected company
                const projects = {!! json_encode($projects) !!};
                const filteredProjects = projects.filter(project => project.company_id === parseInt(
                    selectedCompanyId));

                // Check if there are any projects related to the selected company
                if (filteredProjects.length > 0) {
                    // Populate the project select options
                    filteredProjects.forEach(project => {
                        const option = document.createElement('option');
                        option.value = project.id;
                        option.text = project.name;
                        projectSelect.appendChild(option);
                    });
                } else {
                    // Add a "No project" option
                    const option = document.createElement('option');
                    option.value = '';
                    option.text = 'No project';
                    projectSelect.appendChild(option);
                }
            }
        });

        // Trigger the event listener to populate the project select options on page load
        companySelect.dispatchEvent(new Event('change'));
    </script>
@endpush
