<?php require_once __DIR__ . '/../layout/header.php'; ?>

<section class="profile-page">
    <div class="profile-overview">
        <div class="profile-avatar" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm0 2c-4.14 0-7.5 2.24-7.5 5v1.25c0 .41.34.75.75.75h13.5c.41 0 .75-.34.75-.75V19c0-2.76-3.36-5-7.5-5Z"/>
            </svg>
        </div>
        <div>
            <p class="eyebrow">Crew Profile</p>
            <h1><?= htmlspecialchars($_SESSION['username'] ?? 'Crew Member') ?></h1>
            <p>Kelola keamanan akun dan lanjutkan manajemen karakter favoritmu di One Piece DB.</p>
            <div class="profile-actions">
                <a href="/characters" class="btn">Management Character</a>
                <a href="/logout" class="btn btn-secondary">Logout</a>
            </div>
        </div>
    </div>

    <div class="profile-management-grid">
        <article class="profile-card profile-info-card">
            <p class="eyebrow">Account</p>
            <h2>Profile Summary</h2>
            <dl class="profile-meta">
                <div>
                    <dt>Username</dt>
                    <dd><?= htmlspecialchars($_SESSION['username'] ?? '-') ?></dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd>Active Crew</dd>
                </div>
            </dl>
        </article>

        <article class="profile-card">
            <p class="eyebrow">Security</p>
            <h2>Change Password</h2>
            <p class="profile-card-copy">Gunakan password lama untuk mengonfirmasi perubahan akunmu.</p>

            <?php if (isset($error)): ?>
                <div class="profile-alert profile-alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="profile-alert profile-alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form action="/profile/change-password" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password">
                </div>

                <div class="profile-form-row">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6" autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6" autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn profile-submit-btn">Update Password</button>
            </form>
        </article>
    </div>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>