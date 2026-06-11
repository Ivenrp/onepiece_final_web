<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="detail-container" style="flex-direction: column;">
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div class="detail-img" style="flex: 1; min-width: 300px; max-width: 400px;">
            <img src="<?= htmlspecialchars($character->photo_url ?: 'https://via.placeholder.com/400x500?text=' . urlencode($character->name)) ?>" alt="<?= htmlspecialchars($character->name) ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x500?text=No+Image';" style="width: 100%; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        </div>

        <div class="detail-info" style="flex: 2; min-width: 300px;">
            <h2 style="font-size: 3rem; margin-bottom: 5px;">
                <?= htmlspecialchars($character->name) ?>
            </h2>
            <?php if ($character->epithet): ?>
                <h3 style="color: #666; font-style: italic; margin-bottom: 20px;">"<?= htmlspecialchars($character->epithet) ?>"</h3>
            <?php endif; ?>

            <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; border-left: 5px solid var(--primary-color); margin-bottom: 20px;">
                <?php if ($character->bounty): ?>
                    <p style="font-size: 1.2rem; margin-bottom: 10px;"><strong>Bounty:</strong> <span style="color: var(--primary-color);">฿ <?= number_format($character->bounty, 0, ',', '.') ?></span></p>
                <?php endif; ?>

                <p style="font-size: 1.1rem; margin-bottom: 10px;"><strong>Devil Fruit:</strong> <?= htmlspecialchars($character->devil_fruit ?: 'None') ?></p>
            </div>

            <div class="info-section">
                <h3>Background Story</h3>
                <p style="white-space: pre-line; line-height: 1.8; color: #444;"><?= htmlspecialchars($character->general_information ?: 'No description provided.') ?></p>
            </div>

            <div style="margin-top: 30px;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/characters/edit?id=<?= $character->id ?>" class="btn">Edit Character</a>
                <?php endif; ?>
                <a href="/characters" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>

    <!-- Relational Data Sections -->
    <hr style="margin: 40px 0; border: 0; border-top: 1px solid #ddd;">

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 40px;">
        <!-- Character Arcs -->
        <div>
            <h3 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px;">Character Arcs</h3>
            <?php if (empty($character->arcs)): ?>
                <p style="color: #666; font-style: italic;">No arcs recorded.</p>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php foreach ($character->arcs as $arc): ?>
                        <div style="display: flex; gap: 15px; background: #fff; border: 1px solid #eee; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                            <?php if ($arc->arc_photo_url): ?>
                                <img src="<?= htmlspecialchars($arc->arc_photo_url) ?>" alt="Arc Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div style="width: 80px; height: 80px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.8rem; text-align: center;">No Image</div>
                            <?php endif; ?>
                            <div>
                                <h4 style="margin-bottom: 5px;"><?= htmlspecialchars($arc->arc_name) ?></h4>
                                <p style="color: #666; font-size: 0.95rem;"><?= htmlspecialchars($arc->status ?? 'Participant') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Character Abilities -->
        <div>
            <h3 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px;">Abilities & Powers</h3>
            <?php if (empty($character->abilities)): ?>
                <p style="color: #666; font-style: italic;">No abilities recorded.</p>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <?php foreach ($character->abilities as $ability): ?>
                        <div style="display: flex; gap: 15px; background: #fff; border: 1px solid #eee; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                            <?php if ($ability->ability_photo_url): ?>
                                <img src="<?= htmlspecialchars($ability->ability_photo_url) ?>" alt="Ability Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div style="width: 80px; height: 80px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.8rem; text-align: center;">No Image</div>
                            <?php endif; ?>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 5px;">
                                    <h4 style="margin: 0;"><?= htmlspecialchars($ability->ability_name) ?></h4>
                                    <span style="background: var(--primary-color); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold;"><?= htmlspecialchars($ability->ability_type) ?></span>
                                </div>
                                <?php if ($ability->description): ?>
                                    <p style="color: #555; font-size: 0.9rem; line-height: 1.4; margin-top: 5px;"><?= htmlspecialchars($ability->description) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>