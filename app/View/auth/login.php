<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container auth-login">
    <div class="auth-form-side">
        <h1 class="auth-title">Hey, you back!</h1>
        <p class="auth-subtitle">Just do what you usually do</p>

        <?php if (isset($error)): ?>
            <div class="auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/login" method="POST" class="auth-form">
            <div class="floating-group">
                <label for="username">Email or Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="floating-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="auth-btn">Login</button>

            <div class="auth-links">
                <span>No account? <a href="/register">Create account</a></span>
                <span>I <a href="/forgot-password">forgot my password</a></span>
            </div>
        </form>
    </div>

    <div class="auth-image-side auth-luffy-bg">
        <!-- If local image is missing, we can use an inline style or default background in CSS -->
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>