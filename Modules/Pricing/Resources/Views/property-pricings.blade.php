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

@section('title', 'Property Pricings')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">{{ $property->name }}</h4>
            <div>
                <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addPricingModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Pricings
                </button>
                <a href="{{ route('manage.properties') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="property-amenities-table" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Unit</th>
                        <th>Slab</th>
                        <th>Pricing</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Max Capacity</th>
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
<!-- Add Pricing Modal -->
<div class="modal fade" id="addPricingModal" tabindex="-1" aria-labelledby="addPricingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #4e54c8, #8f94fb);">
        <h5 class="modal-title fw-semibold" id="addAdminModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Add New Pricing
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('property.pricings.add', $property->slug) }}" method="POST">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

          <div class="mb-5 p-3 border rounded-3 shadow-sm bg-light">
            <h6 class="fw-bold text-primary mb-3">
              <i class="bi bi-currency-dollar me-1"></i> Pricing
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Bedrooms</label>
                <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" name="bedrooms" value="{{ old('bedrooms') }}"> @error('bedrooms') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Bathrooms</label>
                <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" name="bathrooms" value="{{ old('bathrooms') }}"> @error('bathrooms') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Slab</label>
                <select class="form-select @error('slab') is-invalid @enderror" name="slab">
                  <option value="Monsoon" @selected(old('slab')=='Monsoon' )>Monsoon</option>
                  <option value="Sunny" @selected(old('slab')=='Sunny' )>Sunny</option>
                  <option value="SuperHot" @selected(old('slab')=='SuperHot' )>SuperHot</option>
                  <option value="Fall" @selected(old('slab')=='Fall' )>Fall</option>
                  <option value="Winter" @selected(old('slab')=='Winter' )>Winter</option>
                </select> @error('slab') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Pricing</label>
                <input type="text" class="form-control @error('pricing') is-invalid @enderror" name="pricing" value="{{ old('pricing') }}"> @error('pricing') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Pricing Type</label>
                <select class="form-select @error('pricing_type') is-invalid @enderror" name="pricing_type">
                  <option value="Night" @selected(old('pricing_type')=='Night' )>Night</option>
                  <option value="Month" @selected(old('pricing_type')=='Month' )>Month</option>
                  <option value="SpecialDay" @selected(old('pricing_type')=='SpecialDay' )>Special Day</option>
                </select> @error('pricing_type') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Capacity</label>
                <input type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity') }}"> @error('capacity') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Max Capacity</label>
                <input type="number" class="form-control @error('max_capacity') is-invalid @enderror" name="max_capacity" value="{{ old('max_capacity') }}"> @error('max_capacity') <div class="invalid-feedback">
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
            <i class="bi bi-check-circle me-1"></i> Add Pricing
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Edit Pricing Modal -->
<div class="modal fade" id="editPricingModal" tabindex="-1" aria-labelledby="editPricingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #4e54c8, #8f94fb);">
        <h5 class="modal-title fw-semibold" id="addAdminModalLabel">
          <i class="bi bi-plus-circle me-2"></i> Edit Pricing
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('edit.pricing', ['pricing' => 0]) }}" method="POST">
        @csrf
        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

          <div class="mb-5 p-3 border rounded-3 shadow-sm bg-light">
            <h6 class="fw-bold text-primary mb-3">
              <i class="bi bi-currency-dollar me-1"></i> Pricing
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Bedrooms</label>
                <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" name="bedrooms" value="{{ old('bedrooms') }}"> @error('bedrooms') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Bathrooms</label>
                <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" name="bathrooms" value="{{ old('bathrooms') }}"> @error('bathrooms') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Slab</label>
                <select class="form-select @error('slab') is-invalid @enderror" name="slab">
                  <option value="Monsoon" @selected(old('slab')=='Monsoon' )>Monsoon</option>
                  <option value="Sunny" @selected(old('slab')=='Sunny' )>Sunny</option>
                  <option value="SuperHot" @selected(old('slab')=='SuperHot' )>SuperHot</option>
                  <option value="Fall" @selected(old('slab')=='Fall' )>Fall</option>
                  <option value="Winter" @selected(old('slab')=='Winter' )>Winter</option>
                </select> @error('slab') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Pricing</label>
                <input type="text" class="form-control @error('pricing') is-invalid @enderror" name="pricing" value="{{ old('pricing') }}"> @error('pricing') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label">Pricing Type</label>
                <select class="form-select @error('pricing_type') is-invalid @enderror" name="pricing_type">
                  <option value="Night" @selected(old('pricing_type')=='Night' )>Night</option>
                  <option value="Month" @selected(old('pricing_type')=='Month' )>Month</option>
                  <option value="SpecialDay" @selected(old('pricing_type')=='SpecialDay' )>Special Day</option>
                </select> @error('pricing_type') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Capacity</label>
                <input type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity') }}"> @error('capacity') <div class="invalid-feedback">
                  {{ $message }}
                </div> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Max Capacity</label>
                <input type="number" class="form-control @error('max_capacity') is-invalid @enderror" name="max_capacity" value="{{ old('max_capacity') }}"> @error('max_capacity') <div class="invalid-feedback">
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
            <i class="bi bi-check-circle me-1"></i> Update Pricing
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
            $('#property-amenities-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("property.pricings", $property->slug) }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'unit', name: 'unit' },
                    { data: 'slab', name: 'slab' },
                    { data: 'pricing', name: 'pricing' },
                    { data: 'pricing_type', name: 'pricing_type' },
                    { data: 'capacity', name: 'capacity' },
                    { data: 'max_capacity', name: 'max_capacity' },
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });

        $(document).on('change', '.pricing-toggle', function () {
            const pricingId = $(this).data('id');
            const isActive = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("pricing.toggle") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: pricingId,
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

    <!-- Edit Pricing -->
     <script>
      $(document).ready(function () {
        // Use event delegation
        $(document).on('click', '[data-bs-target="#editPricingModal"]', function () {
          const modal = $('#editPricingModal');

          // Debugging (optional)
          // console.log($(this).data());

          // Set values in modal fields using jQuery
          modal.find('[name="bedrooms"]').val($(this).data('bedrooms') || '');
          modal.find('[name="bathrooms"]').val($(this).data('bathrooms') || '');
          modal.find('[name="slab"]').val($(this).data('slab') || '');
          modal.find('[name="pricing"]').val($(this).data('pricing') || '');
          modal.find('[name="pricing_type"]').val($(this).data('pricing_type') || '');
          modal.find('[name="capacity"]').val($(this).data('capacity') || '');
          modal.find('[name="max_capacity"]').val($(this).data('max_capacity') || '');

          const pricingId = $(this).data('id');
        
          // Replace `0` with the correct ID in form action
          const form = modal.find('form');
          let action = form.attr('action');
          // Update the form action URL with the actual admin ID
          action = action.replace(/\/0$/, '/' + pricingId);
          form.attr('action', action);
        });
      });

     </script>
@endsection
