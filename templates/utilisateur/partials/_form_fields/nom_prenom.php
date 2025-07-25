<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="nom">Nom</label>
    <input
        type="text"
        name="nom"
        id="nom"
        value="<?= htmlspecialchars($oldInput['nom'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['nom'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="Votre nom"
    />
    <?php if (isset($errors['nom'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['nom'][0]) ?>
        </span>
    <?php endif; ?>
</div>

<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="prenom">Prénom</label>
    <input
        type="text"
        name="prenom"
        id="prenom"
        value="<?= htmlspecialchars($oldInput['prenom'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['prenom'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="Votre prénom"
    />
    <?php if (isset($errors['prenom'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['prenom'][0]) ?>
        </span>
    <?php endif; ?>
</div> 