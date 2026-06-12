<?php require_once __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="/css/admin.css">

<div class="admin-header">
    <div>
        <h1>Add New <span>Character</span></h1>
        <div class="admin-breadcrumb"><a href="/dashboard">Dashboard</a> / Add Character</div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert-dark"><strong>Error:</strong> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="admin-form-wrapper">
    <form action="/characters/store" method="POST" enctype="multipart/form-data" class="admin-form">

        <div class="admin-section-label">General Information</div>
        <hr class="admin-section-divider" style="margin-top: 10px;">

        <div class="dynamic-grid" style="margin-bottom: 15px;">
            <div class="form-group">
                <label for="name">Character Name *</label>
                <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Monkey D. Luffy">
            </div>
            <div class="form-group">
                <label for="role">Role *</label>
                <input type="text" id="role" name="role" class="form-control" placeholder="e.g. Captain" required>
            </div>
            <div class="form-group">
                <label for="epithet">Epithet</label>
                <input type="text" id="epithet" name="epithet" class="form-control" placeholder="e.g. Straw Hat">
            </div>
            <div class="form-group">
                <label for="bounty">Bounty (Berries)</label>
                <input type="number" id="bounty" name="bounty" class="form-control" placeholder="e.g. 3000000000">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="devil_fruit">Devil Fruit</label>
                <input type="text" id="devil_fruit" name="devil_fruit" class="form-control" placeholder="e.g. Gomu Gomu no Mi, or None">
            </div>
        </div>

        <div class="form-group">
            <label>Character Photo</label>
            <div class="img-upload-wrapper">
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg, image/png" onchange="previewImage(this, 'preview-photo')">
                <div class="img-preview-box" id="preview-photo">
                    <img src="" alt="Preview">
                    <button type="button" class="img-clear-btn" onclick="clearImage('photo', 'preview-photo')" title="Remove image">×</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="general_information">Background Story</label>
            <textarea id="general_information" name="general_information" class="form-control" rows="5" placeholder="Write the character's background story..."></textarea>
        </div>

        <hr class="admin-section-divider">

        <div class="admin-section-header">
            <div class="admin-section-label">Character Arcs</div>
            <button type="button" class="btn-sm btn-edit" onclick="addArc()">+ Add Arc</button>
        </div>
        <div id="arcs-container"></div>

        <hr class="admin-section-divider">

        <div class="admin-section-header">
            <div class="admin-section-label">Abilities</div>
            <button type="button" class="btn-sm btn-edit" onclick="addAbility()">+ Add Ability</button>
        </div>
        <div id="abilities-container"></div>

        <div class="admin-form-actions">
            <button type="submit" class="btn" style="padding: 12px 32px; font-size: 1rem;">Save Character</button>
            <a href="/dashboard" class="btn btn-secondary" style="padding: 12px 24px; font-size: 1rem;">Cancel</a>
        </div>
    </form>
</div>

<script>
let arcIndex = 0;
let abilityIndex = 0;

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

// Start with one of each
addArc();
addAbility();
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>