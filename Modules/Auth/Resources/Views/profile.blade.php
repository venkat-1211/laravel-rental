@extends('shared::layouts.master')

@section('title', 'Edit Profile')

@section('styles')

<style>
    .btn-gradient-primary {
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        color: black !important; 
        border: none;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center px-4 py-3">
                    <h4 class="mb-0"><i class="bi bi-person-bounding-box me-2"></i> Edit Profile</h4>
                    <a href="#" class="btn btn-light btn-sm shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                        <i class="bi bi-key me-1"></i> Reset Password
                    </a>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('edit.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section: Basic Info -->
                        <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">Basic Information</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control shadow-sm @error('email') is-invalid @enderror" value="{{ $user->email }}" readonly>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control shadow-sm @error('phone') is-invalid @enderror" value="{{ old('phone', $profile->phone) }}">
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control shadow-sm @error('profile_image') is-invalid @enderror" onchange="profilePreviewImage(event)">
                                @error('profile_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <img id="profilePicPreview" src="{{ $profile->profile_image }}" alt="Profile" class="img-thumbnail mt-2" width="100">
                            </div>
                        </div>

                        <!-- Section: Address -->
                        <hr class="my-4">
                        <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">Address Details</h5>
                        @php $address = ($profile->address); @endphp
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Flat / Apartment</label>
                                <input type="text" name="flat" class="form-control shadow-sm @error('flat') is-invalid @enderror"
                                       value="{{ old('flat', $address['flat'] ?? '') }}">
                                @error('flat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Street</label>
                                <input type="text" name="street" class="form-control shadow-sm @error('street') is-invalid @enderror"
                                       value="{{ old('street', $address['street'] ?? '') }}">
                                @error('street')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control shadow-sm @error('city') is-invalid @enderror"
                                       value="{{ old('city', $address['city'] ?? '') }}">
                                @error('city')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control shadow-sm @error('state') is-invalid @enderror"
                                       value="{{ old('state', $address['state'] ?? '') }}">
                                @error('state')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postcode</label>
                                <input type="text" name="postcode" class="form-control shadow-sm @error('postcode') is-invalid @enderror"
                                       value="{{ old('postcode', $address['postcode'] ?? '') }}">
                                @error('postcode')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section: Aadhaar -->
                        <hr class="my-4">
                        <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">Aadhaar Details</h5>
                        @php $aadhaar = $profile->aadhaar; @endphp
                        <div class="row g-4">
                            <div class="col-md-6">
                                <input type="text" name="name_as_in_aadhaar" class="form-control shadow-sm @error('name_as_in_aadhaar') is-invalid @enderror" placeholder="Name on Aadhaar" value="{{ old('name_as_in_aadhaar', $aadhaar['name_as_in_aadhaar'] ?? '') }}">
                                @error('name_as_in_aadhaar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="aadhaar_no" class="form-control shadow-sm @error('aadhaar_no') is-invalid @enderror" placeholder="Aadhaar Number" value="{{ old('aadhaar_no', $aadhaar['aadhaar_no'] ?? '') }}" oninput="formatAadhaar(this)">
                                @error('aadhaar_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Front Image</label>
                                <input type="file" name="aadhaar_front" class="form-control shadow-sm @error('aadhaar_front') is-invalid @enderror" onchange="aadhaarFrontPreviewImage(event)">
                                @error('aadhaar_front')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <img id="aadhaarFrontPicPreview" src="{{ asset('assets/images/user/aadhaar_front/' . ($aadhaar['aadhaar_front'] ?? 'aadhaar-front.png')) }}" alt="Profile" class="img-thumbnail mt-2" width="60%" height="60%">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Back Image</label>
                                <input type="file" name="aadhaar_back" class="form-control shadow-sm @error('aadhaar_back') is-invalid @enderror" onchange="aadhaarBackPreviewImage(event)">
                                @error('aadhaar_back')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <img id="aadhaarBackPicPreview" src="{{ asset('assets/images/user/aadhaar_back/' . ($aadhaar['aadhaar_back'] ?? 'aadhaar-back.png')) }}" alt="Profile" class="img-thumbnail mt-2" width="60%" height="60%">
                            </div>
                        </div>

                        <!-- Section: Bank & UPI -->
                        <hr class="my-4">
                        <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">Bank & UPI Details</h5>
                        @php $bank = $profile->bank; $upi = $profile->upi; @endphp
                        <div class="row g-4">
                            <div class="col-md-6">
                                <input type="text" name="bank_name" class="form-control shadow-sm @error('bank_name') is-invalid @enderror" placeholder="Bank Name" value="{{ old('bank_name', $bank['bank_name'] ?? '') }}">
                                @error('bank_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="branch" class="form-control shadow-sm @error('branch') is-invalid @enderror" placeholder="Branch" value="{{ old('branch', $bank['branch'] ?? '') }}">
                                @error('branch')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="bank_ac_no" class="form-control shadow-sm @error('bank_ac_no') is-invalid @enderror" placeholder="Account Number" value="{{ old('bank_ac_no', $bank['account_number'] ?? '') }}">
                                @error('bank_ac_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="ifsc" class="form-control shadow-sm @error('ifsc') is-invalid @enderror" placeholder="IFSC Code" value="{{ old('ifsc', $bank['ifsc'] ?? '') }}">
                                @error('ifsc')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="upi_phone" class="form-control shadow-sm @error('upi_phone') is-invalid @enderror" placeholder="UPI Number" value="{{ old('upi_phone', $upi['upi_phone'] ?? '') }}">
                                @error('upi_phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section: GST & PAN -->
                        <hr class="my-4">
                        <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">GST & PAN</h5>
                        @php $pan = $profile->pan; @endphp
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">GST Number</label>
                                <input type="text" name="gst_no" class="form-control shadow-sm @error('gst_no') is-invalid @enderror" placeholder="GST Number" value="{{ old('gst_no', $profile->gst_number) }}">
                                @error('gst_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PAN Number</label>
                                <input type="text" name="pan_no" class="form-control shadow-sm @error('pan_no') is-invalid @enderror" placeholder="PAN Number" value="{{ old('pan_no', $pan['pan_number'] ?? '') }}">
                                @error('pan_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-gradient-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="bi bi-save2 me-1"></i> Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="resetPasswordModalLabel">
          <i class="bi bi-shield-lock-fill me-2"></i> Reset Password
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('reset.password') }}" method="POST">
        <!-- Add CSRF token if using Laravel -->
        @csrf

        <div class="modal-body p-4">

          <div class="mb-3">
            <label for="oldPassword" class="form-label">Old Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPassword" name="old_password" placeholder="Enter old password" required>
              @error('old_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
              <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" name="new_password" placeholder="Enter new password" required>
              @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
              <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirmPassword" name="confirm_password" placeholder="Confirm new password" required>
              @error('confirm_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

        </div>

        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-repeat me-1"></i> Update Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script>
    $(document).ready(function() {
    });

    // Profile Image Preview
    function profilePreviewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
        document.getElementById('profilePicPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Aadhaar Front Image Preview
    function aadhaarFrontPreviewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
        document.getElementById('aadhaarFrontPicPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Aadhaar Back Image Preview
    function aadhaarBackPreviewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('aadhaarBackPicPreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Format Aadhaar 
    function formatAadhaar(input) {
        let value = input.value.replace(/\D/g, ''); // Remove all non-digit characters
        
        if (value.length > 12) {
        value = value.substring(0, 12); // Limit to 12 digits
        }

        // Format the value as XXXX XXXX XXXX
        input.value = value.replace(/(\d{4})(\d{1,4})(\d{1,4})?/, '$1 $2 $3').trim();
    }

</script>
@endsection
