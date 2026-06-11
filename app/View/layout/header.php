<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Piece Characters</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <?php
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $authRoutes = ['/login', '/register', '/forgot-password', '/reset-password'];
    $isAuth = in_array($path, $authRoutes);
    $isLoggedIn = isset($_SESSION['user_id']);
    ?>
    <?php if ($isAuth): ?>
        <link rel="stylesheet" href="/css/auth.css">
    <?php endif; ?>
</head>

<body <?= $isAuth ? 'class="auth-page"' : '' ?>>
    <?php if ($isAuth): ?>
        <nav class="auth-nav" aria-label="Authentication navigation">
            <a href="/" class="auth-nav-brand"><img src="/images/long-logo.png" alt="Logo One Piece" style="height: 50px;"></a>
            <a href="/" class="auth-nav-link">Back to Home</a>
        </nav>
    <?php else: ?>
        <header class="site-header">
            <div class="navbar">
                <a href="/" class="logo" aria-label="One Piece DB Home">
                    <img src="/images/long-logo.png" alt="Logo One Piece">
                </a>

                <details class="mobile-nav-menu">
                    <summary aria-label="Open navigation menu">
                        <span class="hamburger-icon" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </summary>
                    <div class="mobile-nav-panel">
                        <nav class="mobile-nav-links" aria-label="Mobile navigation">
                            <a href="/" class="<?= $path === '/' ? 'is-active' : '' ?>">Home</a>
                            <a href="/characters" class="<?= str_starts_with($path, '/characters') ? 'is-active' : '' ?>">Character</a>
                            <a href="/grandline" class="<?= $path === '/grandline' ? 'is-active' : '' ?>">Grandline</a>
                        </nav>

                        <div class="mobile-nav-actions">
                            <?php if ($isLoggedIn): ?>
                                <span class="mobile-profile-name"><?= htmlspecialchars($_SESSION['username']) ?></span>
                                <a href="/profile">Profile</a>
                                <a href="/characters">Management Character</a>
                                <a href="/logout" class="logout-link">Logout</a>
                            <?php else: ?>
                                <a href="/login">Login</a>
                                <a href="/register" class="mobile-register-link">Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </details>

                <nav class="nav-links" aria-label="Primary navigation">
                    <a href="/" class="<?= $path === '/' ? 'is-active' : '' ?>">Home</a>
                    <a href="/characters" class="<?= str_starts_with($path, '/characters') ? 'is-active' : '' ?>">Character</a>
                    <a href="/grandline" class="<?= $path === '/grandline' ? 'is-active' : '' ?>">Grandline</a>
                </nav>

                <div class="nav-actions">
                    <?php if ($isLoggedIn): ?>
                        <details class="profile-menu">
                            <summary aria-label="Open profile menu">
                                <span class="profile-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" role="img">
                                        <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm0 2c-4.14 0-7.5 2.24-7.5 5v1.25c0 .41.34.75.75.75h13.5c.41 0 .75-.34.75-.75V19c0-2.76-3.36-5-7.5-5Z" />
                                    </svg>
                                </span>
                            </summary>
                            <div class="profile-dropdown">
                                <span class="profile-name"><?= htmlspecialchars($_SESSION['username']) ?></span>
                                <a href="/profile">Profile</a>
                                <a href="/characters">Management Character</a>
                                <a href="/logout" class="logout-link">Logout</a>
                            </div>
                        </details>
                    <?php else: ?>
                        <a href="/login" class="nav-auth-link">Login</a>
                        <a href="/register" class="nav-auth-link nav-auth-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="nav-wave" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2400 800" preserveAspectRatio="none">
                    <g fill="#1e1712ff" transform="matrix(1,0,0,1,5.82373046875,330.5123248100281)">
                        <path d="M-10,10C75.41666666666666,12.708333333333332,231.25,31.541666666666664,400,23C568.75,14.458333333333334,633.3333333333333,-32.25,800,-31C966.6666666666667,-29.75,1033.3333333333333,25.458333333333332,1200,29C1366.6666666666667,32.541666666666664,1433.3333333333333,-16.5,1600,-14C1766.6666666666667,-11.5,1833.3333333333333,38.708333333333336,2000,41C2166.6666666666665,43.291666666666664,2264.5833333333335,-77.79166666666667,2400,-3C2535.4166666666665,71.79166666666667,3254.1666666666665,211.875,2650,400C2045.8333333333335,588.125,156.25,795.8333333333334,-500,900" transform="matrix(1,0,0,1,0,35)"></path>
                    </g>
                </svg>
            </div>
        </header>
    <?php endif; ?>

    <main <?= !$isAuth ? 'class="container"' : '' ?>>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
