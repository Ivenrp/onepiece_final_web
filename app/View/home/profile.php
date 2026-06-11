<?php require_once __DIR__ . '/../layout/header.php'; ?>

<section class="profile-panel">
    <div class="profile-avatar" aria-hidden="true">
        <svg viewBox="0 0 24 24">
            <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm0 2c-4.14 0-7.5 2.24-7.5 5v1.25c0 .41.34.75.75.75h13.5c.41 0 .75-.34.75-.75V19c0-2.76-3.36-5-7.5-5Z"/>
        </svg>
    </div>
    <div>
        <p class="eyebrow">Crew Profile</p>
        <h1><?= htmlspecialchars($_SESSION['username'] ?? 'Crew Member') ?></h1>
        <p>Kelola data karakter favoritmu dan lanjutkan eksplorasi dunia One Piece DB.</p>
        <div class="profile-actions">
            <a href="/characters" class="btn">Management Character</a>
            <a href="/logout" class="btn btn-secondary">Logout</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
