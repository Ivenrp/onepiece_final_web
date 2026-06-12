<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/gallery.css">

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-text">
        <h1>Discover The Grand Line</h1>
        <p>Explore the vast world of One Piece. From the weakest pirates of the East Blue to the fearsome Emperors of the New World. Find your favorite characters and uncover their bounties, devil fruits, and epic background stories.</p>
    </div>
    <div class="hero-image">
        <img src="/images/elements/luffy-tonjok.png" alt="Monkey D. Luffy" onerror="this.style.display='none';">
    </div>
</section>

<!-- FILTER SECTION -->
<section class="filter-section">
    <form action="/characters" method="GET" class="filter-form">
        <div class="filter-group">
            <label for="search">Character Name</label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" placeholder="Search...">
        </div>

        <div class="filter-group">
            <label for="fruit">Devil Fruit User?</label>
            <select id="fruit" name="fruit">
                <option value="">All Characters</option>
                <option value="yes" <?= ($filters['fruit'] ?? '') === 'yes' ? 'selected' : '' ?>>Yes</option>
                <option value="no" <?= ($filters['fruit'] ?? '') === 'no' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="sort">Sort By</label>
            <select id="sort" name="sort">
                <option value="">Newest Added</option>
                <option value="bounty_desc" <?= ($filters['sort'] ?? '') === 'bounty_desc' ? 'selected' : '' ?>>Highest Bounty</option>
                <option value="bounty_asc" <?= ($filters['sort'] ?? '') === 'bounty_asc' ? 'selected' : '' ?>>Lowest Bounty</option>
            </select>
        </div>

        <button type="submit" class="btn" style="padding: 10px 25px; height: 42px;">Apply Filter</button>
        <?php if (!empty($filters['search']) || !empty($filters['fruit']) || !empty($filters['sort'])): ?>
            <a href="/characters" class="btn btn-secondary" style="padding: 10px 20px; height: 42px; line-height: 20px;">Clear</a>
        <?php endif; ?>
    </form>
</section>

<!-- GALLERY SECTION -->
<div class="gallery-grid">
    <?php if (empty($characters)): ?>
        <p style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #fff; border-radius: 8px;">No characters found matching your criteria.</p>
    <?php else: ?>
        <?php foreach ($characters as $character): ?>
            <!-- Card acts as a link to detail page -->
            <a href="/characters/show?id=<?= $character->id ?>" class="bounty-card">
                <div class="bounty-inner">
                    <div class="bounty-header-text">WANTED</div>

                    <div class="bounty-image-container">
                        <img src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/300x400?text=' . urlencode($character->name)) ?>" alt="<?= htmlspecialchars($character->name) ?>" onerror="this.src='https://via.placeholder.com/300x400?text=No+Image';">
                    </div>

                    <div class="bounty-footer-container">
                        <div class="dead-or-alive">DEAD OR ALIVE</div>
                        <h3 class="bounty-name"><?= htmlspecialchars($character->name) ?></h3>
                        <div class="bounty-amount">
                            <span class="currency">฿</span><?= number_format($character->bounty ?? 0, 0, ',', '.') ?>-
                        </div>
                        <div class="bounty-marine-footer">
                            <p class="bounty-small-desc"><?= htmlspecialchars($character->general_information ?? 'No description available.') ?></p>
                            <div class="marine-logo">MARINE</div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php
        // Build query string for pagination links keeping existing filters
        $queryParams = $_GET;

        // Prev button
        $queryParams['page'] = $currentPage - 1;
        $prevUrl = '?' . http_build_query($queryParams);

        // Next button
        $queryParams['page'] = $currentPage + 1;
        $nextUrl = '?' . http_build_query($queryParams);
        ?>

        <a href="<?= $prevUrl ?>" class="page-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>">Previous</a>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php
            $queryParams['page'] = $i;
            $pageUrl = '?' . http_build_query($queryParams);
            ?>
            <a href="<?= $pageUrl ?>" class="page-btn <?= $i === $currentPage ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <a href="<?= $nextUrl ?>" class="page-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">Next</a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>