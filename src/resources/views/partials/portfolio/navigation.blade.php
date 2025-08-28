<nav id="main-nav" class="container py-3  hidden md:block">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#"
           class="fw-semibold text-decoration-none text-dark"
           data-scroll-to="home">
            {{ $profileData['full_name'] ?? 'Portfolio' }}
        </a>

        <ul class="nav gap-2">
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="home">Home</a>
            </li>
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="about">About</a>
            </li>
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="skills">Skills</a>
            </li>
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="experience">Experience</a>
            </li>
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="projects">Projects</a>
            </li>
            <li class="nav-item">
                <a href="#"
                   class="nav-link"
                   data-scroll-to="contact">Contact</a>
            </li>
        </ul>
    </div>

    <style>
        @media (max-width: theme('screens.md')) {
            #main-nav { display: none !important; }
        }

        .nav .nav-link { color: #111827; padding: .5rem .75rem; border-radius: .375rem; }
        .nav .nav-link.is-active { color: #0d6efd; background: rgba(13,110,253,.08); }
        .nav .nav-link:hover { color: #0d6efd; text-decoration: none; }
    </style>

    <script>
        (function() {
            const links = Array.from(document.querySelectorAll('[data-scroll-to]'));
            const ids = ['home','about','skills','experience','projects','contact'];
            const setActive = (id) => {
                links.forEach(a => {
                    a.classList.toggle('is-active', a.getAttribute('data-scroll-to') === id);
                });
            };

            links.forEach(a => {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = a.getAttribute('data-scroll-to');
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    setActive(id);
                    history.replaceState(null, '', `#${id}`);
                });
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) setActive(entry.target.id);
                });
            }, { root: null, rootMargin: '0px 0px -60% 0px', threshold: 0.2 });

            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) observer.observe(el);
            });

            const initial = location.hash ? location.hash.replace('#','') : 'home';
            setActive(initial);
        })();
    </script>
</nav>
