<div>
    <label class="block text-gray-700 font-semibold mb-1" for="telephone">Téléphone</label>
    <input
        type="tel"
        name="telephone"
        id="telephone"
        value="<?= htmlspecialchars($oldInput['telephone'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['telephone'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="ex: 77 123 45 67"
    />
    <?php if (isset($errors['telephone'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['telephone'][0]) ?>
        </span>
    <?php endif; ?>
</div> 