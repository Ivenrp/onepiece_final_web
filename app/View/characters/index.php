<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Character Roster</h2>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/characters/create" class="btn">Add New Character</a>
    <?php endif; ?>
</div>

<div class="grid">
    <?php if (empty($characters)): ?>
        <p>No characters found. Add one!</p>
    <?php else: ?>
        <?php foreach ($characters as $character): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/300x400?text=' . urlencode($character->name)) ?>" alt="<?= htmlspecialchars($character->name) ?>" class="card-img" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=No+Image';">
                <div class="card-body">
                    <h3 class="card-title">
                        <?= htmlspecialchars($character->name) ?>
                        <?php if ($character->epithet): ?>
                            <br><small style="color: #666; font-size: 0.9rem;">"<?= htmlspecialchars($character->epithet) ?>"</small>
                        <?php endif; ?>
                    </h3>

                    <?php if ($character->bounty): ?>
                        <p style="color: var(--primary-color); font-weight: bold; margin-bottom: 5px;">
                            Bounty: ฿ <?= number_format($character->bounty, 0, ',', '.') ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($character->devil_fruit && $character->devil_fruit !== 'None'): ?>
                        <p style="font-size: 0.9rem; margin-bottom: 10px;">
                            <strong>Fruit:</strong> <?= htmlspecialchars($character->devil_fruit) ?>
                        </p>
                    <?php endif; ?>

                    <p class="card-text"><?= htmlspecialchars($character->general_information ?? 'No description available.') ?></p>
                    <div class="card-actions">
                        <a href="/characters/show?id=<?= $character->id ?>" class="btn">View Details</a>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div>
                                <a href="/characters/edit?id=<?= $character->id ?>" class="btn btn-secondary">Edit</a>
                                <form action="/characters/delete" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this character?');">
                                    <input type="hidden" name="id" value="<?= $character->id ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>