<nav class="navbar d-flex justify-content-between align-items-center px-3">
  <div class="d-md-none toggle-btn" onclick="toggleSidebar()">☰</div>

  <div class="d-flex align-items-center gap-3 ms-auto">
    <span class="fw-semibold text-white">{{ auth()->user()->name }}</span>
    <img src="{{ auth()->user()->profile->profile_image }}" 
     class="profile-img rounded-circle" 
     alt="Profile" 
     style="width: 40px; height: 40px; object-fit: cover;">
  </div>
</nav>