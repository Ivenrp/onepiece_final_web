<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container auth-reset">
    <div class="auth-image-side auth-luffy-bg auth-luffy-bg-top">
        <!-- Top Half Image -->
    </div>

    <div class="auth-form-side">
        <h1 class="auth-title auth-title-center">Create your new password</h1>

        <?php if (isset($error)): ?>
            <div class="auth-error auth-message-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="auth-success auth-message-center">
                <?= $success ?>
            </div>
            <div class="auth-success-action">
                <a href="/login" class="auth-btn auth-btn-link">Back to Login</a>
            </div>
        <?php else: ?>
            <form action="/reset-password" method="POST" class="auth-form auth-form-center">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="floating-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>

                <button type="submit" class="auth-btn">reset password</button>
                
                <a href="/login" class="auth-center-link">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>