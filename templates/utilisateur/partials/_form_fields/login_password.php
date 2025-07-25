<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="login">Login</label>
    <input
        type="text"
        name="login"
        id="login"
        value="<?= htmlspecialchars($oldInput['login'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['login'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="votre@email.com"
    />
    <?php if (isset($errors['login'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['login'][0]) ?>
        </span>
    <?php endif; ?>
</div>

<div class="w-1/2">
    <label class="block text-gray-700 font-semibold mb-1" for="password">Mot de passe</label>
    <input
        type="password"
        name="password"
        id="password"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['password'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="Votre mot de passe"
    />
    <?php if (isset($errors['password'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['password'][0]) ?>
        </span>
    <?php endif; ?>
</div> 