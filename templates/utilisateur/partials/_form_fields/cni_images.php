<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="cni_recto_url">CNI Recto</label>
    <input
        type="url"
        name="cni_recto_url"
        id="cni_recto_url"
        value="<?= htmlspecialchars($oldInput['cni_recto_url'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['cni_recto_url'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="URL de l'image recto"
    />
    <?php if (isset($errors['cni_recto_url'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['cni_recto_url'][0]) ?>
        </span>
    <?php endif; ?>
</div>

<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="cni_verso_url">CNI Verso</label>
    <input
        type="url"
        name="cni_verso_url"
        id="cni_verso_url"
        value="<?= htmlspecialchars($oldInput['cni_verso_url'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['cni_verso_url'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="URL de l'image verso"
    />
    <?php if (isset($errors['cni_verso_url'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['cni_verso_url'][0]) ?>
        </span>
    <?php endif; ?>
</div> 