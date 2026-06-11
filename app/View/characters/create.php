<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2>Add New Character</h2>

<?php if (isset($error)): ?>
    <div class="alert" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Error:</strong> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/characters/store" method="POST" enctype="multipart/form-data" style="max-width: 800px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    
    <h3>General Information</h3>
    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Monkey D. Luffy">
        </div>
        <div class="form-group">
            <label for="epithet">Epithet</label>
            <input type="text" id="epithet" name="epithet" class="form-control" placeholder="e.g. Straw Hat">
        </div>
        <div class="form-group">
            <label for="bounty">Bounty (Berries)</label>
            <input type="number" id="bounty" name="bounty" class="form-control" placeholder="e.g. 3000000000">
        </div>
        <div class="form-group">
            <label for="devil_fruit">Devil Fruit</label>
            <input type="text" id="devil_fruit" name="devil_fruit" class="form-control" placeholder="e.g. Gomu Gomu no Mi">
        </div>
    </div>

    <div class="form-group">
        <label for="photo">Character Photo</label>
        <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg, image/png">
    </div>

    <div class="form-group">
        <label for="general_information">Background Story</label>
        <textarea id="general_information" name="general_information" class="form-control" rows="4"></textarea>
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3>Character Arcs</h3>
        <button type="button" class="btn btn-secondary" onclick="addArc()">+ Add Arc</button>
    </div>
    <div id="arcs-container">
        <!-- Dynamic arcs will be added here -->
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3>Abilities</h3>
        <button type="button" class="btn btn-secondary" onclick="addAbility()">+ Add Ability</button>
    </div>
    <div id="abilities-container">
        <!-- Dynamic abilities will be added here -->
    </div>

    <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn" style="font-size: 1.1rem; padding: 10px 30px;">Save Character</button>
        <a href="/characters" class="btn btn-secondary" style="font-size: 1.1rem; padding: 10px 30px;">Cancel</a>
    </div>
</form>

<script>
    let arcIndex = 0;
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

    let abilityIndex = 0;
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

    // Add initial blank rows
    addArc();
    addAbility();
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
