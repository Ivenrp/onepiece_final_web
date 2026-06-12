<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/admin.css">
<link rel="stylesheet" href="/css/gallery.css">
<link rel="stylesheet" href="/css/detail.css">

<div class="admin-header">
    <div>
        <h1><?= htmlspecialchars($character->name) ?> <span>— Details</span></h1>
        <div class="admin-breadcrumb">
            <a href="/dashboard">Dashboard</a> / Character Detail
        </div>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="/characters/edit?id=<?= $character->id ?>" class="btn-sm btn-edit" style="padding: 10px 20px;">Edit</a>
        <a href="/characters/show?id=<?= $character->id ?>" class="btn-sm btn-view" target="_blank" style="padding: 10px 20px;">View Public Page ↗</a>
        <a href="/dashboard" class="btn btn-secondary" style="padding: 10px 20px; font-size: 0.9rem;">← Back</a>
    </div>
</div>

<div class="admin-show-grid">
    <!-- Left: Photo + Actions -->
    <div class="admin-show-photo">
        <img
            src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/300x400?text=' . urlencode($character->name)) ?>"
            alt="<?= htmlspecialchars($character->name) ?>"
            onerror="this.src='https://via.placeholder.com/300x400?text=No+Image';"
        >
        <form action="/characters/delete" method="POST" class="admin-show-actions" onsubmit="return confirm('Permanently delete this character?');">
            <input type="hidden" name="id" value="<?= $character->id ?>">
            <button type="submit" class="btn btn-danger" style="flex: 1;">Delete Character</button>
        </form>
    </div>

    <!-- Right: Info Sections -->
    <div>
        <!-- General Info -->
        <div class="admin-info-section">
            <h3>General Information</h3>
            <div class="admin-info-grid">
                <div class="admin-info-item">
                    <label>Role</label>
                    <span><?= htmlspecialchars($character->role ?? '—') ?></span>
                </div>
                <div class="admin-info-item">
                    <label>Epithet</label>
                    <span><?= htmlspecialchars($character->epithet ?? '—') ?></span>
                </div>
                <div class="admin-info-item">
                    <label>Bounty</label>
                    <span><?= $character->bounty ? '$' . number_format($character->bounty) : '—' ?></span>
                </div>
                <div class="admin-info-item">
                    <label>Devil Fruit</label>
                    <span><?= htmlspecialchars($character->devil_fruit ?? '—') ?></span>
                </div>
                <div class="admin-info-item">
                    <label>ID</label>
                    <span>#<?= $character->id ?></span>
                </div>
                <div class="admin-info-item">
                    <label>Created At</label>
                    <span><?= isset($character->created_at) ? date('d M Y', strtotime($character->created_at)) : '—' ?></span>
                </div>
            </div>
        </div>

        <!-- Background / Bio -->
        <div class="admin-info-section">
            <h3>Background / Bio</h3>
            <p style="color: var(--light-color); line-height: 1.7; font-size: 0.95rem;">
                <?= nl2br(htmlspecialchars($character->general_information ?? 'No information provided.')) ?>
            </p>
        </div>

        <!-- Arcs -->
        <?php if (!empty($character->arcs)): ?>
        <div class="admin-info-section">
            <h3>Character Arcs (<?= count($character->arcs) ?>)</h3>
            <div class="admin-arc-list">
                <?php foreach ($character->arcs as $arc): ?>
                    <div class="admin-arc-item">
                        <?php if ($arc->arc_photo_url): ?>
                            <img src="<?= htmlspecialchars($arc->arc_photo_url) ?>" alt="<?= htmlspecialchars($arc->arc_name) ?>">
                        <?php else: ?>
                            <div style="width:100%;height:140px;background:#1a1410;display:flex;align-items:center;justify-content:center;color:var(--muted-color);font-size:0.8rem;">No Image</div>
                        <?php endif; ?>
                        <div class="admin-arc-info">
                            <h4><?= htmlspecialchars($arc->arc_name) ?></h4>
                            <p><?= htmlspecialchars($arc->status ?? '—') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Abilities -->
        <?php if (!empty($character->abilities)): ?>
        <div class="admin-info-section">
            <h3>Abilities (<?= count($character->abilities) ?>)</h3>
            <div class="admin-ability-list">
                <?php foreach ($character->abilities as $ability): ?>
                    <div class="admin-ability-item">
                        <?php if ($ability->ability_photo_url): ?>
                            <img src="<?= htmlspecialchars($ability->ability_photo_url) ?>" alt="<?= htmlspecialchars($ability->ability_name) ?>">
                        <?php else: ?>
                            <div style="width:100%;height:140px;background:#1a1410;display:flex;align-items:center;justify-content:center;color:var(--muted-color);font-size:0.8rem;">No Image</div>
                        <?php endif; ?>
                        <div class="admin-ability-info">
                            <div class="admin-ability-type"><?= htmlspecialchars($ability->ability_type) ?></div>
                            <h4><?= htmlspecialchars($ability->ability_name) ?></h4>
                            <p><?= nl2br(htmlspecialchars($ability->description ?? '')) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
