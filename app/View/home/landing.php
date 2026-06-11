<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div style="position: relative; overflow: hidden; text-align: center; padding: 60px 20px; min-height: 360px; background: linear-gradient(135deg, rgba(30, 30, 30, 0.88), rgba(66, 66, 66, 0.78)), url('/images/backgrounds/luffy.png') center/cover no-repeat; color: white; border-radius: 10px; margin-bottom: 40px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
    <h1 style="font-size: 3.5rem; margin-bottom: 20px; color: var(--primary-color);">Welcome to Grand Line</h1>
    <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 30px auto; color: #ddd;">The ultimate database for One Piece characters. Discover their bounties, devil fruits, and epic journeys across the seas.</p>

    <div>
        <a href="/characters" class="btn" style="font-size: 1.2rem; padding: 15px 30px;">Explore Characters</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/register" class="btn btn-secondary" style="font-size: 1.2rem; padding: 15px 30px; margin-left: 15px;">Join the Crew</a>
        <?php endif; ?>
    </div>
</div>

<div class="grid" style="margin-top: 40px;">
    <div class="card" style="text-align: center; padding: 30px;">
        <h3 style="color: var(--primary-color);">Comprehensive Data</h3>
        <p>Explore detailed information about abilities, devil fruits, and character arcs.</p>
    </div>
    <div class="card" style="text-align: center; padding: 30px;">
        <h3 style="color: var(--primary-color);">Bounty Tracking</h3>
        <p>Keep track of the highest bounties in the New World and beyond.</p>
    </div>
    <div class="card" style="text-align: center; padding: 30px;">
        <h3 style="color: var(--primary-color);">Community Driven</h3>
        <p>Log in to add and manage your favorite characters directly.</p>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>