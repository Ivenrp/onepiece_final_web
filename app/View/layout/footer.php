    </main>
    <?php
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $authRoutes = ['/login', '/register', '/forgot-password', '/reset-password'];
    $isAuth = in_array($path, $authRoutes);
    ?>
    <?php if (!$isAuth): ?>
        <footer class="site-footer">
            <div class="footer-inner">
                <a href="/" class="footer-logo">
                    <img src="/images/long-logo.png" alt="Logo One Piece">
                </a>
                <nav class="footer-links" aria-label="Footer navigation">
                    <a href="/">Home</a>
                    <a href="/characters">Character</a>
                    <a href="/grandline">Grandline</a>
                </nav>
                <p>&copy; <?= date('Y') ?> One Piece DB. Sail the Grandline, track the legends.</p>
            </div>
        </footer>
    <?php endif; ?>
    <script src="/js/main.js"></script>
    </body>

    </html>
