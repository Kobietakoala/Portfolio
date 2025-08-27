<nav x-data="scrollSpy()" x-init="init()" class="container py-3">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#home"
           @click.prevent="scrollTo('home')"
           class="fw-semibold text-decoration-none text-dark">
            {{ $profileData['full_name'] ?? 'Portfolio' }}
        </a>

        <ul class="nav gap-2">
            <li class="nav-item">
                <a href="#home"
                   @click.prevent="scrollTo('home')"
                   :class="linkClass('home')">Home</a>
            </li>
            <li class="nav-item">
                <a href="#about"
                   @click.prevent="scrollTo('about')"
                   :class="linkClass('about')">About</a>
            </li>
            <li class="nav-item">
                <a href="#skills"
                   @click.prevent="scrollTo('skills')"
                   :class="linkClass('skills')">Skills</a>
            </li>
            <li class="nav-item">
                <a href="#experience"
                   @click.prevent="scrollTo('experience')"
                   :class="linkClass('experience')">Experience</a>
            </li>
            <li class="nav-item">
                <a href="#projects"
                   @click.prevent="scrollTo('projects')"
                   :class="linkClass('projects')">Projects</a>
            </li>
            <li class="nav-item">
                <a href="#contact"
                   @click.prevent="scrollTo('contact')"
                   :class="linkClass('contact')">Contact</a>
            </li>
        </ul>
    </div>

    <style>
        .nav .nav-link,
        .nav a { color: #111827; padding: .5rem .75rem; border-radius: .375rem; }
        .nav a.active { color: #0d6efd; background: rgba(13,110,253,.08); }
        .nav a:hover { color: #0d6efd; text-decoration: none; }
    </style>

    <script>
        function scrollSpy() {
            return {
                active: 'home',
                ids: ['home','about','skills','experience','projects','contact'],
                observer: null,
                init() {
                    // IntersectionObserver do wykrywania aktywnej sekcji
                    const options = { root: null, rootMargin: '0px 0px -60% 0px', threshold: 0.2 };
                    this.observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) this.active = entry.target.id;
                        });
                    }, options);

                    this.ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) this.observer.observe(el);
                    });
                },
                linkClass(id) {
                    return this.active === id ? 'nav-link active' : 'nav-link';
                },
                scrollTo(id) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    this.active = id;
                    history.replaceState(null, '', `#${id}`);
                }
            }
        }
    </script>
</nav>
