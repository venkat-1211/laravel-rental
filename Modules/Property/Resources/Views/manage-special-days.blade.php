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

select.form-select[multiple] {
  min-height: 120px;
  border-radius: 1rem;
  padding: 0.75rem 1rem;
}

textarea.form-control {
  resize: none;
  padding: 0.75rem 1rem;
  border-radius: 1rem;
}


</style>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('title', 'Manage Special Days')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">Manage Special Days</h4>
            <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addSpecialDayModal">
                <i class="bi bi-plus-lg me-1"></i> Add Special Day
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="special-days-table" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        @role('super_admin')
                        <th>Owner</th>
                        @endrole
                        <th>Special Day</th>
                        <th>Description</th>
                        <th>Properties</th>
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
<!-- Add Special Day Modal -->
<div class="modal fade" id="addSpecialDayModal" tabindex="-1" aria-labelledby="addSpecialDayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
        <h5 class="modal-title fw-semibold" id="addSpecialDayModalLabel">
          <i class="bi bi-calendar-plus me-2"></i> Add New Special Day
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('add.special.day') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

            <!-- Special Date -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Special Date</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                <input type="date" name="date" class="form-control rounded-end rounded-pill @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
              </div>
              @error('date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Description</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-chat-left-text"></i></span>
                <textarea name="description" rows="2" class="form-control rounded-end rounded-pill @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              </div>
              @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Select Property -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Select Property</label>
              <select name="property_id[]" class="form-select shadow-sm rounded-pill @error('property_id') is-invalid @enderror" multiple>
                <option disabled>Select one or more</option>
                @foreach ($properties as $property)
                  <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
              </select>
              @error('property_id')
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
            <i class="bi bi-check-circle me-1"></i> Create Special Day
          </button>
        </div>

      </form>
    </div>
  </div>
</div>




<!-- Edit Special Day Modal -->
<div class="modal fade" id="editSpecialDayModal" tabindex="-1" aria-labelledby="editSpecialDayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #00c6ff, #0072ff);">
        <h5 class="modal-title fw-semibold" id="editSpecialDayModalLabel">
          <i class="bi bi-pencil-square me-2"></i> Edit Special Day
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('edit.special.day', ['special_day' => 0]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

            <!-- Special Date -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Special Date</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                <input type="date" name="date"
                  class="form-control rounded-end rounded-pill @error('date') is-invalid @enderror"
                  value="{{ old('date') }}" required>
              </div>
              @error('date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Description</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-chat-left-text"></i></span>
                <textarea name="description" rows="2" class="form-control rounded-end rounded-pill @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              </div>
              @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Select Property -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Select Property</label>
              <select name="property_id" class="form-select shadow-sm rounded-pill @error('property_id') is-invalid @enderror">
                <option disabled>Select one</option>
                @foreach ($properties as $property)
                  <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
              </select>
              @error('property_id')
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
            <i class="bi bi-check-circle me-1"></i> Update Special Day
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
            $('#special-days-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("manage.special.days") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    @if (auth()->user()->hasRole('super_admin'))
                      { data: 'user_info', name: 'user.name' },
                    @endif
                    { data: 'date', name: 'date' },
                    { data: 'description', name: 'description' },
                    { data: 'property', name: 'property' },
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>


<script>
$(document).ready(function () {
  // Use event delegation
  $(document).on('click', '[data-bs-target="#editSpecialDayModal"]', function () {
    const modal = $('#editSpecialDayModal');

    // Debugging (optional)
    // console.log($(this).data());

    // Set values in modal fields using jQuery
    let rawDate = $(this).data('date'); // e.g., "24 Oct 2025"
    let parsedDate = new Date(rawDate);

    // Get components without UTC conversion
    let year = parsedDate.getFullYear();
    let month = String(parsedDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    let day = String(parsedDate.getDate()).padStart(2, '0');

    // Format to YYYY-MM-DD
    let formattedDate = `${year}-${month}-${day}`;

    modal.find('[name="date"]').val(formattedDate);
    modal.find('[name="description"]').val($(this).data('description') || '');
    modal.find('[name="property_id"]').val($(this).data('property-id') || '');

    const specialDayId = $(this).data('id');
  
    // Replace `0` with the correct ID in form action
    const form = modal.find('form');
    let action = form.attr('action');
    // Update the form action URL with the actual admin ID
    action = action.replace(/\/0$/, '/' + specialDayId);
    form.attr('action', action);
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
      $(document).on('change', '.speacial-day-toggle', function () {
          const specialDayId = $(this).data('id');
          const isActive = $(this).is(':checked') ? 1 : 0;

          $.ajax({
              url: '{{ route("special.day.toggle") }}',
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}',
                  id: specialDayId,
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
