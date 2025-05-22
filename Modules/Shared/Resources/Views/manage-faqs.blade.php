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

.modal-content {
  animation: fadeInUp 0.3s ease-in-out;
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translate3d(0, 30px, 0);
  }
  to {
    opacity: 1;
    transform: none;
  }
}


</style>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('title', 'Manage FAQs')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(135deg, #00b09b, #96c93d);">
            <h4 class="mb-0 fw-bold">Manage FAQs</h4>
            <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addFAQModal">
                <i class="bi bi-plus-lg me-1"></i> Add FAQ
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="faqs-table" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        @role('super_admin')
                        <th>Owner</th>
                        @endrole
                        <th>Question</th>
                        <th>Answer</th>
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
<!-- Add FAQ Modal -->
<div class="modal fade" id="addFAQModal" tabindex="-1" aria-labelledby="addFAQModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(90deg, #6a11cb, #2575fc);">
        <h5 class="modal-title fw-semibold" id="addFAQModalLabel">
          <i class="bi bi-question-circle me-2"></i> Add New FAQ
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('add.faq') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body px-4 py-4 bg-light-subtle">
            <div class="mb-4">
                <label for="faq-question" class="form-label fw-bold text-dark">Question</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-chat-text"></i></span>
                    <textarea name="question" id="faq-question"
                    class="form-control rounded-end @error('question') is-invalid @enderror"
                    placeholder="Enter your question here" rows="3" required>{{ old('question') }}</textarea>
                </div>
                @error('question')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="faq-answer" class="form-label fw-bold text-dark">Answer</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                    <textarea name="answer" id="faq-answer"
                    class="form-control rounded-end @error('answer') is-invalid @enderror"
                    placeholder="Enter your answer here" rows="4" required>{{ old('answer') }}</textarea>
                </div>
                @error('answer')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-white px-4 py-3 d-flex justify-content-between rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-check-circle me-1"></i> Create FAQ
          </button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFAQModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">

      <!-- Modal Header -->
      <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(90deg, #00c6ff, #0072ff);">
        <h5 class="modal-title fw-semibold" id="editFAQModalLabel">
          <i class="bi bi-pencil-square me-2"></i> Edit FAQ
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form Start -->
      <form action="{{ route('edit.faq', ['faq' => 0]) }}" method="POST">
        @csrf

        <!-- Modal Body -->
        <div class="modal-body px-4 py-4 bg-light-subtle">
            <div class="mb-4">
                <label for="edit-faq-question" class="form-label fw-bold text-dark">Question</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-chat-text"></i></span>
                    <textarea name="question" id="edit-faq-question"
                    class="form-control rounded-end @error('question') is-invalid @enderror"
                    placeholder="Edit your question" rows="3" required>{{ old('question') }}</textarea>
                </div>
                @error('question') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="edit-faq-answer" class="form-label fw-bold text-dark">Answer</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                    <textarea name="answer" id="edit-faq-answer"
                    class="form-control rounded-end @error('answer') is-invalid @enderror"
                    placeholder="Edit your answer" rows="4" required>{{ old('answer') }}</textarea>
                </div>
                @error('answer') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-white px-4 py-3 d-flex justify-content-between rounded-bottom-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-check-circle me-1"></i> Update FAQ
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
            $('#faqs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("manage.faqs") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    @if (auth()->user()->hasRole('super_admin'))
                      { data: 'user_info', name: 'user.name' },
                    @endif
                    { data: 'question', name: 'question' },
                    { data: 'answer', name: 'answer'},
                    { data: 'status_action', name: 'status_action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>

<script>
$(document).ready(function () {
  // Use event delegation
  $(document).on('click', '[data-bs-target="#editFaqModal"]', function () {
    const modal = $('#editFaqModal');

    // Debugging (optional)
    // console.log($(this).data());

    // Set values in modal fields using jQuery
    modal.find('[name="question"]').val($(this).data('question') || '');
    modal.find('[name="answer"]').val($(this).data('answer') || '');

    const faqId = $(this).data('id');
  
    // Replace `0` with the correct ID in form action
    const form = modal.find('form');
    let action = form.attr('action');
    // Update the form action URL with the actual admin ID
    action = action.replace(/\/0$/, '/' + faqId);
    form.attr('action', action);
  });
});

</script>


    @if ($errors->any())
        <script>
            $(document).ready(function () {
                const addModal = new bootstrap.Modal(document.getElementById('addFAQModal'));
                addModal.show();

                // Convert Laravel validation errors to a JS object
                const validationErrors = @json($errors->toArray());
                console.log("Validation Errors:", validationErrors);

            });
        </script>
    @endif

    <script>
$(document).on('change', '.faq-toggle', function () {
    const faqId = $(this).data('id');
    const isActive = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '{{ route("faqs.toggle") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: faqId,
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
