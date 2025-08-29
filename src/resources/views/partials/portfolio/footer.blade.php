<footer class="bg-dark text-white py-4 mt-auto">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-12 col-md-6">
                <div class="small mb-0">
                    &copy; {{ now()->year }} {{ $profileData['full_name'] ?? 'Twoje Imię' }}. Wszelkie prawa zastrzeżone.
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex justify-content-md-end align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        @if(!empty($profileData['github']))
                            <a href="{{ $profileData['github'] }}"
                               class="text-white-50 text-decoration-none"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="GitHub"
                               title="GitHub">
                                <i class="fab fa-github fa-lg"></i>
                                <span class="visually-hidden">GitHub</span>
                            </a>
                        @endif
                        <a href="mailto:{{ $profileData['mail'] ?? 'email@example.com' }}"
                           class="text-white-50 text-decoration-none"
                           aria-label="Email"
                           title="Email">
                            <i class="fas fa-envelope fa-lg"></i>
                            <span class="visually-hidden">Email</span>
                        </a>
                    </div>

                    <ul class="list-inline mb-0 small">
                        @if(!empty($profileData['github']))
                            <li class="list-inline-item">
                                <a href="{{ $profileData['github'] }}"
                                   class="link-light text-decoration-none"
                                   target="_blank"
                                   rel="noopener noreferrer">GitHub</a>
                            </li>
                            <li class="list-inline-item">·</li>
                        @endif
                        <li class="list-inline-item">
                            <a href="mailto:{{ $profileData['mail'] ?? 'email@example.com' }}"
                               class="link-light text-decoration-none">Email</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
