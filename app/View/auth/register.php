<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container auth-register">
    <div class="auth-image-side auth-luffy-bg">
        <!-- Background image -->
    </div>

    <div class="auth-form-side">
        <h1 class="auth-title">Create an account</h1>
        <p class="auth-subtitle">It seems like you haven't been here yet</p>

        <?php if (isset($error)): ?>
            <div class="auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/register" method="POST" class="auth-form">
            <div class="floating-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="floating-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            
            <div class="floating-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="auth-action-row">
                <span>I have <a href="/login">account!</a></span>
                <button type="submit" class="auth-btn auth-btn-inline">Register</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
