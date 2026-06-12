<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container auth-reset">
    <div class="auth-image-side auth-luffy-bg auth-luffy-bg-top">
        <!-- Top Half Image --> 
    </div>

    <div class="auth-form-side">
        <h1 class="auth-title auth-title-center">Enter your email address to reset<br>your password</h1>

        <?php if (isset($error)): ?>
            <div class="auth-error auth-message-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="auth-success auth-message-center">
                <?= $success ?> <!-- Raw HTML for the mock link -->
            </div>
        <?php else: ?>
            <form action="/forgot-password" method="POST" class="auth-form auth-form-center">
                <div class="floating-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <button type="submit" class="auth-btn">Send Link</button>
                
                <a href="/login" class="auth-center-link">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>