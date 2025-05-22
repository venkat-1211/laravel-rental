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
/* Datable Properties show codes */
.property-pill {
        position: relative;
        display: inline-block;
    }

    .property-badge {
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #fff;
        border-radius: 999px;
        background: linear-gradient(135deg, #3a7bd5, #00d2ff) !important;
        white-space: nowrap;
    }

    .btn-remove-property {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 20px;
        height: 20px;
        border: none;
        border-radius: 50%;
        font-size: 14px;
        color: white;
        background-color: #dc3545;
        cursor: pointer;
        line-height: 18px;
        padding: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        z-index: 10;
    }

    .btn-remove-property:hover {
        background-color: #bb2d3b;
    }


</style>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('title', 'Manage Coupons')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">Manage Coupons</h4>
            <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                <i class="bi bi-plus-lg me-1"></i> Add Coupon
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
                        <th>Code</th>
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
<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
        <h5 class="modal-title fw-semibold" id="addCouponModalLabel">
          <i class="bi bi-tag-fill me-2"></i> Add New Coupon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Coupon Form -->
      <form action="{{ route('add.coupon') }}" method="POST">
        @csrf

        <div class="modal-body p-4">
          <div class="row g-4">

            <!-- Coupon Code -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Coupon Code</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
              </div>
              @error('code')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Value -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Value</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-cash-coin"></i></span>
                <input type="number" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
              </div>
              @error('value')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control shadow-sm @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
              @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Type -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Discount Type</label>
              <select name="type" class="form-select shadow-sm @error('type') is-invalid @enderror" required>
                <option disabled selected>Select Type</option>
                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="amount" {{ old('type') == 'amount' ? 'selected' : '' }}>Amount</option>
              </select>
              @error('type')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Start Date -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Start Date</label>
              <input type="date" name="start_date" class="form-control shadow-sm @error('start_date') is-invalid @enderror" value="{{ old('start_date') ?? now()->toDateString() }}" required>
              @error('start_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- End Date -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">End Date</label>
              <input type="date" name="end_date" class="form-control shadow-sm @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
              @error('end_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Select Properties -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Applicable Properties @role('super_admin')<span class="text-muted small">(Leave empty for global)</span>@endrole</label>
              <select name="property_ids[]" class="form-select shadow-sm @error('property_ids') is-invalid @enderror" multiple>
                @foreach ($properties as $property)
                  <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
              </select>
              @error('property_ids')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light px-4 py-3 justify-content-between rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Create Coupon
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(to right, #00c6ff, #0072ff);">
        <h5 class="modal-title fw-semibold" id="editCouponModalLabel">
          <i class="bi bi-pencil-square me-2"></i> Edit Coupon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Coupon Form -->
      <form action="{{ route('edit.coupon', ['coupon' => 0]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Modal Body -->
        <div class="modal-body p-4">
          <div class="row g-4">

            <!-- Coupon Code -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Coupon Code</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
              </div>
              @error('code')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Value -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Value</label>
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-light"><i class="bi bi-cash-coin"></i></span>
                <input type="number" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
              </div>
              @error('value')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control shadow-sm @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
              @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Type -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Discount Type</label>
              <select name="type" class="form-select shadow-sm @error('type') is-invalid @enderror" required>
                <option disabled selected>Select Type</option>
                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="amount" {{ old('type') == 'amount' ? 'selected' : '' }}>Amount</option>
              </select>
              @error('type')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Start Date -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Start Date</label>
              <input type="date" name="start_date" class="form-control shadow-sm @error('start_date') is-invalid @enderror" value="{{ old('start_date') ?? now()->toDateString() }}" required>
              @error('start_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- End Date -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">End Date</label>
              <input type="date" name="end_date" class="form-control shadow-sm @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
              @error('end_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Select Properties -->
            <div class="col-md-12">
              <label class="form-label fw-semibold">Applicable Properties @role('super_admin')<span class="text-muted small">(Leave empty for global)</span>@endrole</label>
              <select name="property_ids[]" class="form-select shadow-sm @error('property_ids') is-invalid @enderror" multiple>
                @foreach ($properties as $property)
                  <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
              </select>
              @error('property_ids')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light px-4 py-3 justify-content-between rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Update Coupon
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

 <!-- View Coupon Modal -->
<div class="modal fade" id="viewCouponModal" tabindex="-1" aria-labelledby="viewCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
      <div class="modal-header text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
        <h5 class="modal-title fw-semibold" id="viewCouponModalLabel">
          <i class="bi bi-eye-fill me-2"></i> View Coupon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Coupon Code</label>
            <div class="form-control bg-light" id="view_code"></div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Value</label>
            <div class="form-control bg-light" id="view_value"></div>
          </div>

          <div class="col-md-12">
            <label class="form-label fw-semibold">Description</label>
            <div class="form-control bg-light" id="view_description"></div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Type</label>
            <div class="form-control bg-light" id="view_type"></div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Start Date</label>
            <div class="form-control bg-light" id="view_start_date"></div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">End Date</label>
            <div class="form-control bg-light" id="view_end_date"></div>
          </div>

          <div class="col-md-12">
            <label class="form-label fw-semibold">Applicable Properties</label>
            <div id="view_properties" class="d-flex flex-wrap gap-2"></div>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light px-4 py-3 justify-content-end rounded-bottom-4">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Close
        </button>
      </div>
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
                ajax: '{{ route("manage.coupons") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    @if (auth()->user()->hasRole('super_admin'))
                      { data: 'user_info', name: 'user.name' },
                    @endif
                    { data: 'code', name: 'code' },
                    { data: 'description', name: 'description' },
                    { data: 'properties', name: 'properties' },
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>


    <script>
      $(document).ready(function () {
        // Use event delegation
        $(document).on('click', '[data-bs-target="#editCouponModal"]', function () {
          const modal = $('#editCouponModal');

          modal.find('[name="code"]').val($(this).data('code') || '');
          modal.find('[name="description"]').val($(this).data('description') || '');
          modal.find('[name="value"]').val($(this).data('value') || '');
          modal.find('[name="type"]').val($(this).data('type') || '');
          modal.find('[name="start_date"]').val($(this).data('start_date') || '');
          modal.find('[name="end_date"]').val($(this).data('end_date') || '');

          var properties = $(this).data('properties');

          if (Array.isArray(properties)) {
            modal.find('[name="property_ids[]"]').val(properties).trigger('change'); // if using Select2
          }

          const couponId = $(this).data('id');
        
          // Replace `0` with the correct ID in form action
          const form = modal.find('form');
          let action = form.attr('action');
          // Update the form action URL with the actual admin ID
          action = action.replace(/\/0$/, '/' + couponId);
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
      $(document).on('change', '.coupon-toggle', function () {
          const specialDayId = $(this).data('id');
          const isActive = $(this).is(':checked') ? 1 : 0;

          $.ajax({
              url: '{{ route("coupon.toggle") }}',
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

      function removeProperty(coupon_id, property_id) {
          if (confirm('Are you sure you want to remove this property?')) {
              $.ajax({
                  url: '{{ url('remove-coupon-property') }}/' + coupon_id,
                  type: 'POST',
                  data: {
                      _token: '{{ csrf_token() }}',
                      property_id: property_id
                  },
                  success: function (response) {
                      $('#property-' + property_id).remove();
                      toastr.success(response.message);
                  },
                  error: function () {
                      toastr.error('Failed to remove property.');
                  }
              });
          }
      }
    </script>

    <!-- View Coupon Modal -->
    <script>
function loadCouponView(el) {
    document.getElementById('view_code').textContent = el.dataset.code;
    document.getElementById('view_description').textContent = el.dataset.description;
    document.getElementById('view_type').textContent = el.dataset.type;
    document.getElementById('view_value').textContent = el.dataset.value;
    document.getElementById('view_start_date').textContent = el.dataset.start_date;
    document.getElementById('view_end_date').textContent = el.dataset.end_date;

    // Properties (JSON encoded)
    const properties = JSON.parse(el.dataset.properties || '[]');
    const container = document.getElementById('view_properties');
    container.innerHTML = ''; // Clear existing

    if (properties.length > 0) {
        properties.forEach(prop => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary-subtle border border-primary text-primary px-3 py-2 rounded-pill shadow-sm';
            badge.innerHTML = `<i class="bi bi-house-door-fill me-1"></i> ${prop.name}`;
            container.appendChild(badge);
        });
    } else {
        container.innerHTML = '<div class="form-control bg-light">Global Coupon</div>';
    }
}
</script>

@endsection
