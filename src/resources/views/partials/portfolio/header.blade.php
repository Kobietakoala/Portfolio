<div id="home" class="container">
    <div class="profile-header text-center">
        @if($profileData['avatar'])
            <div class="avatar-container mb-3">
                <img src="{{ $profileData['avatar']['url'] }}"
                     alt="{{ $profileData['full_name'] }}"
                     class="avatar-image rounded-circle"
                     style="width: 150px; height: 150px; object-fit: cover;">
            </div>
        @else
            <div class="avatar-placeholder mb-3">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                     style="width: 150px; height: 150px; margin: 0 auto;">
                    <i class="fas fa-user fa-4x text-muted"></i>
                </div>
            </div>
        @endif

        <h1 class="profile-name">{{ $profileData['full_name'] }}</h1>

        @if($profileData['position'])
            <h3 class="profile-position text-muted">
                {{ $profileData['position'] }}
            </h3>
        @endif
    </div>
</div>
