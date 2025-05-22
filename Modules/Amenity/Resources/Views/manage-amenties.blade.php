@extends('shared::layouts.master')

@section('styles')
<style>
    .card-header {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }
    .btn-add-admin {
        background: linear-gradient(135deg, #ff6a00, #ee0979);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }
    .btn-add-admin:hover {
        background: linear-gradient(135deg, #ee0979, #ff6a00);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn {
    transition: all 0.2s ease-in-out;
}
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}
.form-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
}

.form-switch .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ced4da;
    transition: 0.4s;
    border-radius: 34px;
}

.form-switch .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
}

.form-switch input:checked + .slider {
    background-color: #0d6efd;
}

.form-switch input:checked + .slider:before {
    transform: translateX(24px);
}
.form-switch input:checked + .slider {
    box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
}

.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff, #00bfff);
    color: #fff;
    border: none;
}

.btn-gradient-danger {
    background: linear-gradient(45deg, #ff4b5c, #ff6b6b);
    color: #fff;
    border: none;
}

.btn-gradient-primary:hover,
.btn-gradient-danger:hover {
    filter: brightness(1.1);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    transform: translateY(-1px);
    transition: all 0.2s ease-in-out;
}


</style>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('title', 'Manage Amenities')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">Manage Amenities</h4>
            <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="bi bi-plus-lg me-1"></i> Add Amenity
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="amenities-table" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        @role('super_admin')
                        <th>Owner</th>
                        @endrole
                        <th>Name</th>
                        <th>Icon</th>
                        <th class="text-center">Enabled\Disabled</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Add Amenity Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #4e54c8, #8f94fb);">
        <h5 class="modal-title fw-semibold" id="addAdminModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Add New Amenity
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('add.amenity') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

            <!-- Amenity Picture Upload -->
            <div class="col-12 text-center">
              <label class="form-label fw-semibold">Amenity Image</label>
              <div class="mb-2 position-relative d-inline-block">
                <img id="amenityPicPreview" src="{{ asset('assets/images/amenities/building.png') }}" alt="Preview"
                  class="rounded-circle border shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                <label for="amenityPicInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1"
                  style="cursor: pointer; font-size: 14px;">
                  <i class="bi bi-pencil"></i>
                </label>
              </div>
              <input type="file" name="icon" id="amenityPicInput" accept="image/*"
                class="form-control d-none @error('icon') is-invalid @enderror"
                onchange="previewImage(event)">
              @error('icon')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Amenity Name -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Amenity Name</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                <input type="text" name="name"
                  class="form-control shadow-sm rounded-end rounded-pill @error('name') is-invalid @enderror"
                  placeholder="e.g., Swimming Pool" value="{{ old('name') }}" required>
              </div>
              @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light d-flex justify-content-between rounded-bottom-4 px-4 py-3">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-check-circle me-1"></i> Create Amenity
          </button>
        </div>
      </form>

    </div>
  </div>
</div>



<!-- Edit Amenity Modal -->
<div class="modal fade" id="editAmenityModal" tabindex="-1" aria-labelledby="editAmenityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #00c6ff, #0072ff);">
        <h5 class="modal-title" id="editAmenityModalLabel">
          <i class="bi bi-pencil-square me-2"></i> Edit Amenity
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('edit.amenity', ['id' => 0]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body px-4 py-3" style="max-height: 70vh; overflow-y: auto;">
          <div class="row g-4">

            <!-- Amenity Image -->
            <div class="col-12 text-center">
              <label class="form-label fw-semibold">Amenity Icon</label>
              <div class="mb-2">
                <input type="file" name="icon" id="editAmenityImage" accept="image/*"
                  class="form-control w-auto mx-auto @error('icon') is-invalid @enderror"
                  onchange="previewImage(event, 'editAmenityPreview')">
                @error('icon')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <img id="editAmenityPreview"
                   src="{{ $amenity->icon_url ?? asset('assets/images/amenities/building.png') }}"
                   class="rounded-circle shadow"
                   style="width: 100px; height: 100px; object-fit: cover;"
                   alt="Amenity Preview">
            </div>

            <!-- Name Field -->
            <div class="col-md-12">
              <label class="form-label">Amenity Name</label>
              <input type="text" name="name" class="form-control rounded-pill shadow-sm"
                     value="{{ old('name', $amenity->name ?? '') }}" required>
              @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-check-circle me-1"></i> Update Amenity
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#amenities-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("manage.amenities") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    @if (auth()->user()->hasRole('super_admin'))
                      { data: 'user_info', name: 'user.name' },
                    @endif
                    { data: 'name', name: 'name' },
                    { data: 'icon', name: 'icon', orderable: false, searchable: false },
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>
<script>
  function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function () {
      const preview = document.getElementById('amenityPicPreview');
      preview.src = reader.result;
    };
    if (input.files && input.files[0]) {
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<script>
$(document).ready(function () {
  // Use event delegation
  $(document).on('click', '[data-bs-target="#editAmenityModal"]', function () {
    const modal = $('#editAmenityModal');

    // Debugging (optional)
    // console.log($(this).data());

    // Set values in modal fields using jQuery
    modal.find('[name="name"]').val($(this).data('name') || '');

    const amenityId = $(this).data('id');
  
    // Replace `0` with the correct ID in form action
    const form = modal.find('form');
    let action = form.attr('action');
    // Update the form action URL with the actual admin ID
    action = action.replace(/\/0$/, '/' + amenityId);
    form.attr('action', action);

    const defaultImagePath = '/assets/images/amenities/building.png'; // adjust as needed
    const basePath = window.location.origin + '/'; // or use your asset() URL if needed
    const profileImage = 'assets/images/amenities/' + $(this).data('icon');
    const fullPath = profileImage ? basePath + profileImage : defaultImagePath;

    modal.find('#editAmenityPreview').attr('src', fullPath);
  });
});

</script>


    @if ($errors->any())
        <script>
            $(document).ready(function () {
                const addModal = new bootstrap.Modal(document.getElementById('addAmenityModal'));
                addModal.show();

                // Convert Laravel validation errors to a JS object
                const validationErrors = @json($errors->toArray());
                console.log("Validation Errors:", validationErrors);

            });
        </script>
    @endif

    <script>
$(document).on('change', '.amenity-toggle', function () {
    const amenityId = $(this).data('id');
    const isActive = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '{{ route("amenities.toggle") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: amenityId,
            is_active: isActive
        },
        success: function (response) {
            toastr.success(response.message);
        },
        error: function () {
            toastr.error('Failed to update status.');
        }
    });
});
</script>
@endsection
