<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/gallery.css">
<link rel="stylesheet" href="/css/detail.css">

<!-- HERO DETAIL SECTION -->
<div class="detail-hero">
    <div class="hero-info">
        <div class="hero-title-row">
            <div>
                <h1 class="hero-title"><?= htmlspecialchars($character->name) ?></h1>
                <!-- Showing author as dynamic text if needed, here just static or empty -->
                <div style="font-weight: 600; color: #5A4A42;">Author: admin123</div>
            </div>
            <?php if (!empty($character->devil_fruit) && $character->devil_fruit !== 'None'): ?>
                <div class="hero-df"><?= htmlspecialchars($character->devil_fruit) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="hero-desc">
            <?= nl2br(htmlspecialchars($character->general_information ?? 'No information available.')) ?>
        </div>
        
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-label">role</span>
                <span class="stat-value"><?= htmlspecialchars($character->role ?? 'Unknown') ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">epithet / crew</span>
                <span class="stat-value"><?= htmlspecialchars($character->epithet ?? 'Unknown') ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">bounty</span>
                <span class="stat-value"><?= $character->bounty ? '$' . number_format($character->bounty) : 'Unknown' ?></span>
            </div>
        </div>
    </div>
    
    <div class="hero-image">
        <img src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/300x400?text=' . urlencode($character->name)) ?>" alt="<?= htmlspecialchars($character->name) ?>">
    </div>
</div>

<!-- ARC VERSION SECTION -->
<?php if (!empty($character->arcs)): ?>
<div class="section-title-wrapper">
    <div class="section-title">arc version</div>
    <span class="more-link">more -></span>
</div>
<div class="horizontal-scroll">
    <?php foreach ($character->arcs as $arc): ?>
        <div class="scroll-item" style="width: 250px;">
            <div class="bounty-card">
                <div class="bounty-inner">
                    <div class="bounty-image-container">
                        <img src="<?= htmlspecialchars($arc->arc_photo_url ?: 'https://via.placeholder.com/250x350?text=Arc') ?>" alt="<?= htmlspecialchars($arc->name) ?>">
                        <div class="bounty-gradient-overlay"></div>
                    </div>
                    <div class="bounty-text-container">
                        <h3 class="bounty-title"><?= htmlspecialchars($arc->name) ?></h3>
                        <p class="bounty-desc"><?= htmlspecialchars($arc->status ?? '') ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ABILITIES SECTION -->
<?php if (!empty($character->abilities)): ?>
<div class="section-title-wrapper">
    <div class="section-title"><?= htmlspecialchars($character->name) ?> abilities</div>
    <span class="more-link">more -></span>
</div>
<div class="horizontal-scroll">
    <?php foreach ($character->abilities as $ability): ?>
        <div class="scroll-item">
            <div class="ability-card" onclick="openAbilityModal('<?= htmlspecialchars(addslashes($ability->name)) ?>', '<?= htmlspecialchars(addslashes($ability->type)) ?>', '<?= htmlspecialchars(addslashes($ability->description ?? '')) ?>', '<?= htmlspecialchars(addslashes($ability->ability_photo_url ?: 'https://via.placeholder.com/400x200?text=Ability')) ?>')">
                <div class="ability-inner">
                    <div class="ability-img-container">
                        <img src="<?= htmlspecialchars($ability->ability_photo_url ?: 'https://via.placeholder.com/400x200?text=Ability') ?>" alt="<?= htmlspecialchars($ability->name) ?>">
                    </div>
                    <div class="ability-content">
                        <img src="/images/elements/skull.png" class="ability-skull" alt="Skull" onerror="this.style.display='none';">
                        <div class="ability-title"><?= htmlspecialchars($ability->name) ?></div>
                        <div class="ability-desc"><?= nl2br(htmlspecialchars($ability->description ?? '')) ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- MODAL POPUP FOR ABILITY -->
<div class="modal-overlay" id="abilityModal" onclick="closeAbilityModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="close-modal" onclick="closeAbilityModal()">&times;</button>
        <div class="modal-body">
            <img id="modalImg" src="" alt="Ability Image">
            <h2 id="modalTitle">Ability Name</h2>
            <div style="color: var(--accent-color); font-weight: bold; margin-bottom: 10px;" id="modalType">Type</div>
            <p id="modalDesc">Description goes here...</p>
        </div>
    </div>
</div>

<script>
function openAbilityModal(name, type, desc, img) {
    document.getElementById('modalTitle').textContent = name;
    document.getElementById('modalType').textContent = type;
    document.getElementById('modalDesc').textContent = desc || 'No description available.';
    document.getElementById('modalImg').src = img;
    
    document.getElementById('abilityModal').classList.add('active');
}

function closeAbilityModal(e) {
    if (e && e.target !== document.getElementById('abilityModal') && e.target.className !== 'close-modal') {
        return;
    }
    document.getElementById('abilityModal').classList.remove('active');
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>