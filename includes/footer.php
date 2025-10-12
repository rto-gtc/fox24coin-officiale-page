
 

    <footer class="text-bg-dark">
      <div class="container py-5">
        <div class="row g-5">
          <div class="col-lg-4 col-md-6">
            <h4 class="footer-heading mb-4 text-uppercase text-warning">FOX24Coin</h4>
            <p class="text-secondary mb-3">Bridging Trust and Technology</p>
            <div class="d-flex pt-2 gap-2">
              <a href="https://t.me/fox24coin" target="_blank" class="btn btn-social" aria-label="Telegram">
                <i class="fab fa-telegram"></i>
              </a>
              <a href="https://x.com/fox24coin" target="_blank" class="btn btn-social" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://www.facebook.com/profile.php?id=61575920820740" target="_blank" class="btn btn-social" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://discord.com/channels/1415882766930677774/1415883138810511451" target="_blank" class="btn btn-social" aria-label="Discord">
                <i class="fab fa-discord"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-2 col-md-6">
            <h4 class="footer-heading mb-4 text-uppercase text-warning">Links</h4>
            <ul class="list-unstyled mb-0">
              <li><a class="link-secondary d-block mb-2" href="roadmap.html">Roadmap</a></li>
              <li><a class="link-secondary d-block mb-2" href="team2.html">Our Team</a></li>
              <li><a class="link-secondary d-block mb-2" href="index.html#contact">Contact Us</a></li>
              <li><a class="link-secondary d-block mb-2" href="widget.html">Widget</a></li>
              <li><a class="link-secondary d-block mb-2" href="market.html">Crypto Market</a></li>
              <li><a class="link-secondary d-block" href="scam-protection.html">Scam Protection</a></li>
              <li><a class="link-secondary d-block" href="index.html">Home</a></li>
              <li><a class="link-secondary d-block" href="vision.html">Fox24 Vision</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="footer-heading mb-4 text-uppercase text-warning">Resources</h4>
            <ul class="list-unstyled mb-0">
              <li><a class="link-secondary d-block mb-2" href="tokenomics.html">Tokenomics</a></li>
              <li><a class="link-secondary d-block mb-2" href="whitepaper.pdf" target="_blank">Whitepaper</a></li>
              <li><a class="link-secondary d-block mb-2" href="index.html#hero">Join Presale</a></li>
              <li><a class="link-secondary d-block mb-2" href="https://fox24coin-1.dexkit.app/">DEX Exchange</a></li>
              <li><a class="link-secondary d-block mb-2" href="https://www.coingecko.com">Coingecko</a></li>
              <li><a class="link-secondary d-block mb-2" href="https://coinmarketcap.com">Coinmarketcap</a></li>
              <li><a class="link-secondary d-block" href="https://etherscan.io">Etherscan</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="footer-heading mb-4 text-uppercase text-warning">Contact Info</h4>
            <ul class="list-unstyled text-secondary mb-0">
              <li class="d-flex mb-3">
                <i class="fa fa-map-marker-alt me-3 pt-1 text-warning"></i>
                Henryka Sienkiewicza 85/87/lok. 1,<br>90-057 Łódź
              </li>
              <li class="d-flex mb-3">
                <i class="fa fa-phone-alt me-3 pt-1 text-warning"></i>+48 698 000 441
              </li>
              <li class="d-flex">
                <i class="fa fa-envelope me-3 pt-1 text-warning"></i>support@fox24coin.com
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="container border-top border-secondary py-4">
        <div class="row align-items-center">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; <a class="fw-bold text-warning text-decoration-none" href="#">Fox24Coin</a>, All Rights Reserved.
          </div>
          <div class="col-md-6 text-center text-md-end">
            <a href="Privacy-Policy-and-Cookies-Policy.html" class="link-secondary text-decoration-none">Privacy & Cookies Policy</a>
          </div>
        </div>
      </div>
    </footer>

    <a href="#" class="back-to-top" id="scrollTopBtn" aria-label="Scroll to top">
        <i class="fa fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            const themeIcon = themeToggle.querySelector('i');
            // Odczytaj zapisany motyw z localStorage lub ustaw domyślny 'dark'
            const currentTheme = localStorage.getItem('theme') || 'dark';

            const applyTheme = (theme) => {
                if (theme === 'light') {
                    document.body.classList.add('light-mode');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                } else {
                    document.body.classList.remove('light-mode');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                }
            };

            // Zastosuj motyw przy ładowaniu strony
            applyTheme(currentTheme);

            // Obsługa kliknięcia w przycisk zmiany motywu
            themeToggle.addEventListener('click', () => {
                const newTheme = document.body.classList.contains('light-mode') ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });
        }

        const scrollTopBtn = document.getElementById('scrollTopBtn');
        if (scrollTopBtn) {
            // Pokaż/ukryj przycisk w zależności od pozycji przewijania
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            // Płynne przewijanie na górę po kliknięciu
            scrollTopBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
    </script>
