<div>
    <label class="block text-gray-700 font-semibold mb-1" for="cni">N° Carte d'identité</label>
    <input
        type="text"
        name="cni"
        id="cni"
        value="<?= htmlspecialchars($oldInput['cni'] ?? '') ?>"
        class="w-full border rounded-lg px-3 py-2 transition
        <?= isset($errors['cni'])
            ? 'border-red-500 focus:ring-red-500 bg-red-50'
            : 'border-gray-200 focus:ring-maxitOrange/60 focus:border-maxitOrange'
        ?> focus:outline-none focus:ring-2"
        placeholder="ex: 1234567890123"
        maxlength="13"
    />
    
    <?php if (isset($errors['cni'])): ?>
        <span class="text-red-500 text-sm mt-1 block flex items-center">
            <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <?= htmlspecialchars($errors['cni'][0]) ?>
        </span>
    <?php endif; ?>

    <!-- Alerte CNI non trouvé -->
    <div id="cniAlert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2">
        <div class="flex items-center">
            <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm">CNI non trouvé dans la base de données</span>
        </div>
    </div>

    <!-- Indicateur de chargement -->
    <div id="cniLoading" class="hidden bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mt-2">
        <div class="flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm">Vérification en cours...</span>
        </div>
    </div>

    <!-- Succès -->
    <div id="cniSuccess" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-2">
        <div class="flex items-center">
            <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm">Informations récupérées avec succès</span>
        </div>
    </div>
</div> 