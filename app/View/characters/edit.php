<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/admin.css">

<div class="admin-header">
    <div>
        <h1>Edit <span><?= htmlspecialchars($character->name) ?></span></h1>
        <div class="admin-breadcrumb">
            <a href="/dashboard">Dashboard</a> /
            <a href="/characters/admin-show?id=<?= $character->id ?>">Character Detail</a> /
            Edit
        </div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert-dark"><strong>Error:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="admin-form-wrapper">
    <form action="/characters/update" method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="id" value="<?= $character->id ?>">

        <div class="admin-section-label">General Information</div>
        <hr class="admin-section-divider" style="margin-top: 10px;">

        <div class="dynamic-grid" style="margin-bottom: 15px;">
            <div class="form-group">
                <label for="name">Character Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($character->name) ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Role *</label>
                <input type="text" id="role" name="role" class="form-control" value="<?= htmlspecialchars($character->role ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="epithet">Epithet</label>
                <input type="text" id="epithet" name="epithet" class="form-control" value="<?= htmlspecialchars($character->epithet ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="bounty">Bounty (Berries)</label>
                <input type="number" id="bounty" name="bounty" class="form-control" value="<?= htmlspecialchars($character->bounty ?? '') ?>">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="devil_fruit">Devil Fruit</label>
                <input type="text" id="devil_fruit" name="devil_fruit" class="form-control" value="<?= htmlspecialchars($character->devil_fruit ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Character Photo</label>
            <div class="img-upload-wrapper">
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg, image/png" onchange="previewImage(this, 'preview-photo')">
                <!-- Existing photo preview -->
                <div class="img-preview-box <?= $character->photo_url ? 'visible' : '' ?>" id="preview-photo">
                    <img src="<?= htmlspecialchars($character->photo_url ?? '') ?>" alt="Current Photo">
                    <button type="button" class="img-clear-btn" onclick="clearImage('photo', 'preview-photo')" title="Remove image">×</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="general_information">Background Story</label>
            <textarea id="general_information" name="general_information" class="form-control" rows="5"><?= htmlspecialchars($character->general_information ?? '') ?></textarea>
        </div>

        <hr class="admin-section-divider">

        <div class="admin-section-header">
            <div class="admin-section-label">Character Arcs</div>
            <button type="button" class="btn-sm btn-edit" onclick="addArc()">+ Add Arc</button>
        </div>
        <div id="arcs-container">
            <?php foreach ($character->arcs as $index => $arc): ?>
                <div class="dynamic-block">
                    <button type="button" class="dynamic-block-remove" onclick="this.parentElement.remove()">×</button>
                    <div class="dynamic-grid">
                        <div class="form-group">
                            <label>Arc Name *</label>
                            <input type="text" name="arcs[<?= $index ?>][name]" class="form-control" required value="<?= htmlspecialchars($arc->arc_name) ?>">
                        </div>
                        <div class="form-group">
                            <label>Status / Description</label>
                            <input type="text" name="arcs[<?= $index ?>][status]" class="form-control" value="<?= htmlspecialchars($arc->status ?? '') ?>">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Arc Photo <?= $arc->arc_photo_url ? '(upload to replace)' : '' ?></label>
                            <div class="img-upload-wrapper">
                                <input type="file" name="arc_photos[<?= $index ?>]" class="form-control" accept="image/jpeg, image/png"
                                    onchange="previewImage(this, 'arc-preview-<?= $index ?>')">
                                <div class="img-preview-box <?= $arc->arc_photo_url ? 'visible' : '' ?>" id="arc-preview-<?= $index ?>">
                                    <img src="<?= htmlspecialchars($arc->arc_photo_url ?? '') ?>" alt="Arc Photo">
                                    <button type="button" class="img-clear-btn"
                                        onclick="this.closest('.img-upload-wrapper').querySelector('input[type=file]').value=''; this.closest('.img-preview-box').classList.remove('visible');"
                                        title="Remove">×</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <hr class="admin-section-divider">

        <div class="admin-section-header">
            <div class="admin-section-label">Abilities</div>
            <button type="button" class="btn-sm btn-edit" onclick="addAbility()">+ Add Ability</button>
        </div>
        <div id="abilities-container">
            <?php foreach ($character->abilities as $index => $ability): ?>
                <div class="dynamic-block">
                    <button type="button" class="dynamic-block-remove" onclick="this.parentElement.remove()">×</button>
                    <div class="dynamic-grid">
                        <div class="form-group">
                            <label>Ability Name *</label>
                            <input type="text" name="abilities[<?= $index ?>][name]" class="form-control" required value="<?= htmlspecialchars($ability->ability_name) ?>">
                        </div>
                        <div class="form-group">
                            <label>Type *</label>
                            <select name="abilities[<?= $index ?>][type]" class="form-control" required>
                                <option value="Devil Fruit" <?= $ability->ability_type == 'Devil Fruit' ? 'selected' : '' ?>>Devil Fruit</option>
                                <option value="Haki" <?= $ability->ability_type == 'Haki' ? 'selected' : '' ?>>Haki</option>
                                <option value="Weapon" <?= $ability->ability_type == 'Weapon' ? 'selected' : '' ?>>Weapon</option>
                                <option value="Physical" <?= $ability->ability_type == 'Physical' ? 'selected' : '' ?>>Physical</option>
                                <option value="Other" <?= $ability->ability_type == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Description</label>
                            <textarea name="abilities[<?= $index ?>][description]" class="form-control" rows="3"><?= htmlspecialchars($ability->description ?? '') ?></textarea>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Ability Photo <?= $ability->ability_photo_url ? '(upload to replace)' : '' ?></label>
                            <div class="img-upload-wrapper">
                                <input type="file" name="ability_photos[<?= $index ?>]" class="form-control" accept="image/jpeg, image/png"
                                    onchange="previewImage(this, 'ability-preview-<?= $index ?>')">
                                <div class="img-preview-box <?= $ability->ability_photo_url ? 'visible' : '' ?>" id="ability-preview-<?= $index ?>">
                                    <img src="<?= htmlspecialchars($ability->ability_photo_url ?? '') ?>" alt="Ability Photo">
                                    <button type="button" class="img-clear-btn"
                                        onclick="this.closest('.img-upload-wrapper').querySelector('input[type=file]').value=''; this.closest('.img-preview-box').classList.remove('visible');"
                                        title="Remove">×</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn" style="padding: 12px 32px; font-size: 1rem;">Update Character</button>
            <a href="/dashboard" class="btn btn-secondary" style="padding: 12px 24px; font-size: 1rem;">Cancel</a>
        </div>
    </form>
</div>

<script>
let arcIndex = <?= count($character->arcs) ?>;
let abilityIndex = <?= count($character->abilities) ?>;

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.querySelector('img').src = e.target.result;
            preview.classList.add('visible');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearImage(inputId, previewId) {
    document.getElementById(inputId).value = '';
    const preview = document.getElementById(previewId);
    preview.querySelector('img').src = '';
    preview.classList.remove('visible');
}

function makeImgPreviewHtml(inputName, previewId) {
    return `
        <div class="form-group" style="grid-column: 1 / -1;">
            <label>Photo</label>
            <div class="img-upload-wrapper">
                <input type="file" name="${inputName}" class="form-control" accept="image/jpeg, image/png"
                    onchange="previewImage(this, '${previewId}')">
                <div class="img-preview-box" id="${previewId}">
                    <img src="" alt="Preview">
                    <button type="button" class="img-clear-btn"
                        onclick="this.closest('.img-upload-wrapper').querySelector('input[type=file]').value=''; this.closest('.img-preview-box').classList.remove('visible');"
                        title="Remove">×</button>
                </div>
            </div>
        </div>`;
}

function addArc() {
    const container = document.getElementById('arcs-container');
    const pid = `arc-preview-${arcIndex}`;
    const div = document.createElement('div');
    div.className = 'dynamic-block';
    div.innerHTML = `
        <button type="button" class="dynamic-block-remove" onclick="this.parentElement.remove()">×</button>
        <div class="dynamic-grid">
            <div class="form-group">
                <label>Arc Name *</label>
                <input type="text" name="arcs[${arcIndex}][name]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status / Description</label>
                <input type="text" name="arcs[${arcIndex}][status]" class="form-control">
            </div>
            ${makeImgPreviewHtml(`arc_photos[${arcIndex}]`, pid)}
        </div>`;
    container.appendChild(div);
    arcIndex++;
}

function addAbility() {
    const container = document.getElementById('abilities-container');
    const pid = `ability-preview-${abilityIndex}`;
    const div = document.createElement('div');
    div.className = 'dynamic-block';
    div.innerHTML = `
        <button type="button" class="dynamic-block-remove" onclick="this.parentElement.remove()">×</button>
        <div class="dynamic-grid">
            <div class="form-group">
                <label>Ability Name *</label>
                <input type="text" name="abilities[${abilityIndex}][name]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Type *</label>
                <select name="abilities[${abilityIndex}][type]" class="form-control" required>
                    <option value="Devil Fruit">Devil Fruit</option>
                    <option value="Haki">Haki</option>
                    <option value="Weapon">Weapon</option>
                    <option value="Physical">Physical</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Description</label>
                <textarea name="abilities[${abilityIndex}][description]" class="form-control" rows="3"></textarea>
            </div>
            ${makeImgPreviewHtml(`ability_photos[${abilityIndex}]`, pid)}
        </div>`;
    container.appendChild(div);
    abilityIndex++;
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>