<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/admin.css">

<div class="admin-header">
    <div>
        <h1>Character <span>Management</span></h1>
        <div class="admin-breadcrumb">Admin Dashboard · <?= count($characters) ?> character(s) total</div>
    </div>
    <a href="/characters/create" class="btn" style="padding: 10px 24px;">+ Add New Character</a>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="alert-dark"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="admin-char-grid">
    <?php if (empty($characters)): ?>
        <div class="empty-state">
            <p style="font-size: 1.1rem; margin-bottom: 10px;">No characters yet.</p>
            <a href="/characters/create" class="btn">Add First Character</a>
        </div>
    <?php else: ?>
        <?php foreach ($characters as $character): ?>
            <div class="admin-char-card">
                <img
                    src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/300x400?text=' . urlencode($character->name)) ?>"
                    alt="<?= htmlspecialchars($character->name) ?>"
                    class="admin-card-img"
                    onerror="this.src='https://via.placeholder.com/300x400?text=No+Image';"
                >
                <div class="admin-card-body">
                    <div class="admin-card-name"><?= htmlspecialchars($character->name) ?></div>
                    <div class="admin-card-meta">
                        <span><?= htmlspecialchars($character->role ?? 'Unknown') ?></span>
                        <?php if ($character->epithet): ?>
                            · "<?= htmlspecialchars($character->epithet) ?>"
                        <?php endif; ?>
                        <?php if ($character->bounty): ?>
                            <br>Bounty: $<?= number_format($character->bounty) ?>
                        <?php endif; ?>
                    </div>
                    <div class="admin-card-actions">
                        <a href="/characters/admin-show?id=<?= $character->id ?>" class="btn-sm btn-view">View</a>
                        <a href="/characters/edit?id=<?= $character->id ?>" class="btn-sm btn-edit">Edit</a>
                        <form action="/characters/delete" method="POST" style="display:inline;" onsubmit="return confirm('Delete <?= htmlspecialchars(addslashes($character->name)) ?>? This cannot be undone.');">
                            <input type="hidden" name="id" value="<?= $character->id ?>">
                            <button type="submit" class="btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
