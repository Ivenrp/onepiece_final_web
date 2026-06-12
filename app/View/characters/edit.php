<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2>Edit Character: <?= htmlspecialchars($character->name) ?></h2>

<?php if (isset($error)): ?>
    <div class="alert" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Error:</strong> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/characters/update" method="POST" enctype="multipart/form-data" style="max-width: 800px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <input type="hidden" name="id" value="<?= $character->id ?>">
    
    <h3>General Information</h3>
    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" class="form-control" required value="<?= htmlspecialchars($character->name) ?>">
        </div>
        <div class="form-group">
            <label for="epithet">Epithet</label>
            <input type="text" id="epithet" name="epithet" class="form-control" value="<?= htmlspecialchars($character->epithet ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="bounty">Bounty (Berries)</label>
            <input type="number" id="bounty" name="bounty" class="form-control" value="<?= htmlspecialchars($character->bounty ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="devil_fruit">Devil Fruit</label>
            <input type="text" id="devil_fruit" name="devil_fruit" class="form-control" value="<?= htmlspecialchars($character->devil_fruit ?? '') ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="photo">Character Photo (Leave blank to keep existing)</label>
        <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg, image/png">
        <?php if($character->photo_url): ?>
            <p style="font-size: 0.8rem; margin-top: 5px;"><a href="<?= htmlspecialchars($character->photo_url) ?>" target="_blank">View Current Photo</a></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="general_information">Background Story</label>
        <textarea id="general_information" name="general_information" class="form-control" rows="4"><?= htmlspecialchars($character->general_information ?? '') ?></textarea>
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3>Character Arcs</h3>
        <button type="button" class="btn btn-secondary" onclick="addArc()">+ Add Arc</button>
    </div>
    <div id="arcs-container">
        <!-- Existing Arcs -->
        <?php foreach($character->arcs as $index => $arc): ?>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px; position: relative;">
                <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 10px; top: 10px; color: red; border: none; background: none; cursor: pointer;">X Remove</button>
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Arc Name *</label>
                        <input type="text" name="arcs[<?= $index ?>][name]" class="form-control" required value="<?= htmlspecialchars($arc->arc_name) ?>">
                    </div>
                    <div class="form-group">
                        <label>Status / Role</label>
                        <input type="text" name="arcs[<?= $index ?>][status]" class="form-control" value="<?= htmlspecialchars($arc->status ?? '') ?>">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Arc Photo (Leave blank to keep existing)</label>
                        <input type="file" name="arc_photos[<?= $index ?>]" class="form-control" accept="image/jpeg, image/png">
                        <?php if($arc->arc_photo_url): ?>
                            <p style="font-size: 0.8rem; margin-top: 5px;"><a href="<?= htmlspecialchars($arc->arc_photo_url) ?>" target="_blank">View Current Photo</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3>Abilities</h3>
        <button type="button" class="btn btn-secondary" onclick="addAbility()">+ Add Ability</button>
    </div>
    <div id="abilities-container">
        <!-- Existing Abilities -->
        <?php foreach($character->abilities as $index => $ability): ?>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px; position: relative;">
                <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 10px; top: 10px; color: red; border: none; background: none; cursor: pointer;">X Remove</button>
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
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
                        <input type="text" name="abilities[<?= $index ?>][description]" class="form-control" value="<?= htmlspecialchars($ability->description ?? '') ?>">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Ability Photo (Leave blank to keep existing)</label>
                        <input type="file" name="ability_photos[<?= $index ?>]" class="form-control" accept="image/jpeg, image/png">
                        <?php if($ability->ability_photo_url): ?>
                            <p style="font-size: 0.8rem; margin-top: 5px;"><a href="<?= htmlspecialchars($ability->ability_photo_url) ?>" target="_blank">View Current Photo</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn" style="font-size: 1.1rem; padding: 10px 30px;">Update Character</button>
        <a href="/characters" class="btn btn-secondary" style="font-size: 1.1rem; padding: 10px 30px;">Cancel</a>
    </div>
</form>

<script>
    let arcIndex = <?= count($character->arcs) ?>;
    function addArc() {
        const container = document.getElementById('arcs-container');
        const div = document.createElement('div');
        div.style.cssText = "background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px; position: relative;";
        div.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 10px; top: 10px; color: red; border: none; background: none; cursor: pointer;">X Remove</button>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Arc Name *</label>
                    <input type="text" name="arcs[${arcIndex}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status / Role</label>
                    <input type="text" name="arcs[${arcIndex}][status]" class="form-control">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Arc Photo</label>
                    <input type="file" name="arc_photos[${arcIndex}]" class="form-control" accept="image/jpeg, image/png">
                </div>
            </div>
        `;
        container.appendChild(div);
        arcIndex++;
    }

    let abilityIndex = <?= count($character->abilities) ?>;
    function addAbility() {
        const container = document.getElementById('abilities-container');
        const div = document.createElement('div');
        div.style.cssText = "background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px; position: relative;";
        div.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 10px; top: 10px; color: red; border: none; background: none; cursor: pointer;">X Remove</button>
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
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
                    <input type="text" name="abilities[${abilityIndex}][description]" class="form-control">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Ability Photo</label>
                    <input type="file" name="ability_photos[${abilityIndex}]" class="form-control" accept="image/jpeg, image/png">
                </div>
            </div>
        `;
        container.appendChild(div);
        abilityIndex++;
    }
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>