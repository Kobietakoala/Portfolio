<section id="skills" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Umiejętności</h2>

        <div id="skills-container">
            @if(isset($profileData['skills']) && count($profileData['skills']) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="width: 25%;">Kategoria</th>
                                <th scope="col" style="width: 75%;">Umiejętności</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profileData['skills'] as $skillCategory)
                                <tr>
                                    <td class="fw-bold align-middle">
                                        @if(isset($skillCategory['logo']) && $skillCategory['logo'])
                                            <img src="{{ $skillCategory['logo'] }}"
                                                 alt="{{ $skillCategory['name'] }}"
                                                 class="me-2"
                                                 style="width: 24px; height: 24px; object-fit: contain;">
                                        @endif
                                        {{ $skillCategory['name'] }}
                                    </td>
                                    <td>
                                        @if(isset($skillCategory['skills']) && is_array($skillCategory['skills']) && count($skillCategory['skills']) > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($skillCategory['skills'] as $skill)
                                                    <span class="badge bg-primary rounded-pill">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Brak umiejętności</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Ładowanie...</span>
                    </div>
                    <p class="mt-2">Ładowanie umiejętności...</p>
                </div>
            @endif
        </div>
    </div>
</section>
