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

@section('title', 'Property Nearbies')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">{{ $property->name }}</h4>
            <div>
                <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addAmenityModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Nearbies
                </button>
                <a href="{{ route('manage.properties') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="property-nearbies-table" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nearby Info</th>
                        <th class="text-center">Enabled/Disabled</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Add Property Nearby Modal -->
<div class="modal fade" id="addAmenityModal" tabindex="-1" aria-labelledby="addAmenityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #4e54c8, #8f94fb);">
        <h5 class="modal-title fw-semibold" id="addAdminModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Add New Nearby
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('property.nearbies.add', $property->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

          <div class="mb-4 p-3 border rounded-3 shadow-sm bg-light">
            <h6 class="fw-bold text-primary mb-3">
              <i class="bi bi-geo-alt-fill me-1"></i> Nearby
            </h6>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Nearby Item</label>
                <select class="form-select @error('nearby_item') is-invalid @enderror" name="nearby_item">
                  <option value="Mahal" @selected(old('nearby_item')=='Mahal' )>Mahal</option>
                  <option value="Hospital" @selected(old('nearby_item')=='Hospital' )>Hospital</option>
                  <option value="University" @selected(old('nearby_item')=='University' )>University</option>
                  <option value="Tech Park" @selected(old('nearby_item')=='Tech Park' )>Tech Park</option>
                  <option value="Bus Stand" @selected(old('nearby_item')=='Bus Stand' )>Bus Stand</option>
                  <option value="Railway Station" @selected(old('nearby_item')=='Railway Station' )>Railway Station</option>
                </select> @error('nearby_item') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Distance</label>
                <input type="text" class="form-control @error('nearby_distance') is-invalid @enderror" name="nearby_distance" value="{{ old('nearby_distance') }}"> @error('nearby_distance') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Image</label>
                <input type="file" class="form-control @error('nearby_image') is-invalid @enderror" name="nearby_image"> @error('nearby_image') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
            </div>
          </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light d-flex justify-content-between rounded-bottom-4 px-4 py-3">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-check-circle me-1"></i> Add Nearby
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
            $('#property-nearbies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("property.nearbies", $property->slug) }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nearby_info', name: 'item' },
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });

        $(document).on('change', '.nearby-toggle', function () {
            const nearbyId = $(this).data('id');
            const isActive = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("nearby.toggle") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: nearbyId,
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
