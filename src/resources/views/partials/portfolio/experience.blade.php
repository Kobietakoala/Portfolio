
<section id="experience" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Doświadczenie zawodowe</h2>

        <div id="experience-container">
            @if(isset($profileData['experience']) && count($profileData['experience']) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 20%;">Firma</th>
                            <th scope="col" style="width: 20%;">Stanowisko</th>
                            <th scope="col" style="width: 15%;">Okres</th>
                            <th scope="col" style="width: 30%;">Opis</th>
                            <th scope="col" style="width: 15%;">Technologie</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profileData['experience'] as $companyName => $experiences)
                            @foreach($experiences as $index => $experience)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ count($experiences) }}" class="align-middle fw-bold">
                                            @if(isset($experience['link']) && $experience['link'])
                                                <a href="{{ $experience['link'] }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="text-decoration-none">
                                                    {{ $companyName }}
                                                    <i class="fas fa-external-link-alt ms-1 small text-muted"></i>
                                                </a>
                                            @else
                                                {{ $companyName }}
                                            @endif
                                        </td>
                                    @endif

                                    <td class="align-middle">
                                        <strong>{{ $experience['position'] ?? 'Brak stanowiska' }}</strong>
                                    </td>

                                    <td class="align-middle">
                                            <span class="badge bg-secondary rounded-pill">
                                                {{ $experience['date'] ?? 'Brak daty' }}
                                            </span>
                                    </td>

                                    <td class="align-middle">
                                        @if(isset($experience['description']) && !empty($experience['description']))
                                            <div class="text-muted small">
                                                {{ Str::limit($experience['description'], 150) }}
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Brak opisu</span>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        @if(isset($experience['skills']) && is_array($experience['skills']) && count($experience['skills']) > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($experience['skills'] as $skill)
                                                    <span class="badge bg-primary rounded-pill small">
                                                            {{ $skill }}
                                                        </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic small">Brak technologii</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Alternatywny widok dla urządzeń mobilnych -->
                <div class="d-block d-md-none mt-4">
                    @foreach($profileData['experience'] as $companyName => $experiences)
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    @if(isset($experiences[0]['link']) && $experiences[0]['link'])
                                        <a href="{{ $experiences[0]['link'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-white text-decoration-none">
                                            {{ $companyName }}
                                            <i class="fas fa-external-link-alt ms-1 small"></i>
                                        </a>
                                    @else
                                        {{ $companyName }}
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($experiences as $experience)
                                    <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-1">{{ $experience['position'] ?? 'Brak stanowiska' }}</h6>
                                            <span class="badge bg-secondary">{{ $experience['date'] ?? 'Brak daty' }}</span>
                                        </div>

                                        @if(isset($experience['description']) && !empty($experience['description']))
                                            <p class="text-muted small mb-2">
                                                {{ $experience['description'] }}
                                            </p>
                                        @endif

                                        @if(isset($experience['skills']) && is_array($experience['skills']) && count($experience['skills']) > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($experience['skills'] as $skill)
                                                    <span class="badge bg-primary rounded-pill small">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-briefcase fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted">Brak doświadczenia zawodowego</h4>
                    <p class="text-muted">Doświadczenie zawodowe nie zostało jeszcze dodane.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    /* Dodatkowe style dla lepszego wyglądu */
    .table td {
        vertical-align: middle;
    }

    .badge.bg-primary {
        font-size: 0.75em;
    }

    .badge.bg-secondary {
        font-size: 0.8em;
    }

    /* Responsywne ukrywanie tabeli na małych ekranach */
    @media (max-width: 767.98px) {
        .table-responsive {
            display: none !important;
        }
    }

    @media (min-width: 768px) {
        .d-block.d-md-none {
            display: none !important;
        }
    }

    /* Hover effect dla linków firm */
    .table tbody tr:hover td a {
        color: #0d6efd !important;
        text-decoration: underline !important;
    }
</style>
