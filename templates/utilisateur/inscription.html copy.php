<?php
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];
$signupError = $_SESSION['signup_error'] ?? null;
$successMessage = $_SESSION['success_message'] ?? null;

unset($_SESSION['errors']);
unset($_SESSION['old_input']);
unset($_SESSION['signup_error']);
unset($_SESSION['success_message']);
?>

<body class="bg-gradient-to-br from-maxitOrange/80 via-maxitGray to-maxitOrangeDark/70 min-h-screen flex flex-col items-center justify-center">

<!-- Message d'erreur général -->
<?php if (!empty($signupError)): ?>
    <div class="bg-red-900 bg-opacity-50 border border-red-500 rounded-xl p-4 mb-6 w-full max-w-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-red-300 text-sm"><?= htmlspecialchars($signupError) ?></span>
        </div>
    </div>
<?php endif; ?>

<!-- Message de succès -->
<?php if (!empty($successMessage)): ?>
    <div class="bg-green-900 bg-opacity-50 border border-green-500 rounded-xl p-4 mb-6 w-full max-w-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-300 text-sm"><?= htmlspecialchars($successMessage) ?></span>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white/90 rounded-2xl shadow-maxit p-8 w-full max-w-md backdrop-blur-md">
    <div class="flex flex-col items-center mb-6">
        <div class="w-16 h-16 rounded-full bg-maxitOrange flex items-center justify-center mb-2 shadow-lg">
            <span class="text-white text-3xl font-black">M</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-maxitOrange mb-1 tracking-tight">
            Créer un compte principal
        </h2>
        <p class="text-gray-500 text-sm">Bienvenue chez Maxit Sénégal</p>
    </div>

    <form id="registerForm" enctype="multipart/form-data" method="POST" class="space-y-4" action="<?php echo BASE_URL; ?>inscription">
        
        <!-- Champ CNI en haut -->
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
                    ?>
                focus:outline-none focus:ring-2"
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

        <div class="flex gap-4">
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
                        ?>
                    focus:outline-none focus:ring-2"
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
                        ?>
                    focus:outline-none focus:ring-2"
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
        </div>

        <div class="flex gap-4">
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
                        ?>
                    focus:outline-none focus:ring-2"
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
                        ?>
                    focus:outline-none focus:ring-2"
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
        </div>

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
                    ?>
                focus:outline-none focus:ring-2"
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

        <div class="flex gap-4 items-end">
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-1" for="cni_recto">Photo Recto CNI</label>
                <label for="cni_recto" class="flex items-center cursor-pointer w-full">
                    <span id="cni_recto_label" class="flex-1 truncate text-gray-500 bg-white border rounded-l-lg px-3 py-2
                        <?= isset($errors['cni_recto']) ? 'border-red-500' : 'border-gray-200' ?>">
                        Aucun fichier choisi
                    </span>
                    <span class="bg-maxitOrange text-white px-4 py-2 rounded-r-lg font-semibold hover:bg-maxitOrangeDark transition">Choisir</span>
                    <input
                            type="file"
                            name="cni_recto"
                            id="cni_recto"
                            accept="image/*"
                            class="hidden"
                            onchange="document.getElementById('cni_recto_label').textContent = this.files[0]?.name || 'Aucun fichier choisi';"
                    />
                </label>
                <?php if (isset($errors['cni_recto'])): ?>
                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                        <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?= htmlspecialchars($errors['cni_recto'][0]) ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-1" for="cni_verso">Photo Verso CNI</label>
                <label for="cni_verso" class="flex items-center cursor-pointer w-full">
                    <span id="cni_verso_label" class="flex-1 truncate text-gray-500 bg-white border rounded-l-lg px-3 py-2
                        <?= isset($errors['cni_verso']) ? 'border-red-500' : 'border-gray-200' ?>">
                        Aucun fichier choisi
                    </span>
                    <span class="bg-maxitOrange text-white px-4 py-2 rounded-r-lg font-semibold hover:bg-maxitOrangeDark transition">Choisir</span>
                    <input
                            type="file"
                            name="cni_verso"
                            id="cni_verso"
                            accept="image/*"
                            class="hidden"
                            onchange="document.getElementById('cni_verso_label').textContent = this.files[0]?.name || 'Aucun fichier choisi';"
                    />
                </label>
                <?php if (isset($errors['cni_verso'])): ?>
                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                        <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?= htmlspecialchars($errors['cni_verso'][0]) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <button
                type="submit"
                class="w-full bg-maxitOrange text-white font-bold py-2 rounded-lg shadow hover:bg-white hover:text-maxitOrange hover:border hover:border-maxitOrange transition-all duration-200 text-lg mt-6"
        >
            S'inscrire
        </button>
    </form>

    <p class="mt-6 text-center text-gray-500 text-sm">
        Déjà un compte ?
        <a href="<?php echo BASE_URL; ?>login" class="text-maxitOrange font-semibold hover:underline">Connectez-vous</a>
    </p>
</div>

<!-- Modal Popup -->
<div id="customModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl transform transition-all">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-maxitOrange/10 flex items-center justify-center mr-3">
                <svg id="modalIcon" class="w-6 h-6 text-maxitOrange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Information</h3>
        </div>
        <p id="modalMessage" class="text-gray-600 mb-6 text-sm leading-relaxed">Message du popup</p>
        <div class="flex gap-3">
            <button id="modalCancel" class="flex-1 px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium hidden">
                Annuler
            </button>
            <button id="modalConfirm" class="flex-1 px-4 py-2 bg-maxitOrange text-white rounded-lg hover:bg-maxitOrangeDark transition-colors text-sm font-medium">
                OK
            </button>
        </div>
    </div>
</div>

<script>
// Fonction pour afficher un popup personnalisé
function showCustomPopup(title, message, type = 'info', showCancel = false) {
    return new Promise((resolve) => {
        const modal = document.getElementById('customModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');
        const modalConfirm = document.getElementById('modalConfirm');
        const modalCancel = document.getElementById('modalCancel');

        // Configuration selon le type
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        // Icônes selon le type
        if (type === 'warning') {
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.134 16.5c-.77.833.192 2.5 1.732 2.5z"></path>';
        } else if (type === 'error') {
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        } else {
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        }

        // Afficher/masquer le bouton annuler
        if (showCancel) {
            modalCancel.classList.remove('hidden');
        } else {
            modalCancel.classList.add('hidden');
        }

        // Afficher le modal
        modal.classList.remove('hidden');

        // Gestionnaires d'événements
        const confirmHandler = () => {
            modal.classList.add('hidden');
            modalConfirm.removeEventListener('click', confirmHandler);
            modalCancel.removeEventListener('click', cancelHandler);
            resolve(true);
        };

        const cancelHandler = () => {
            modal.classList.add('hidden');
            modalConfirm.removeEventListener('click', confirmHandler);
            modalCancel.removeEventListener('click', cancelHandler);
            resolve(false);
        };

        modalConfirm.addEventListener('click', confirmHandler);
        modalCancel.addEventListener('click', cancelHandler);

        // Fermer avec Escape
        const escapeHandler = (e) => {
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
                document.removeEventListener('keydown', escapeHandler);
                modalConfirm.removeEventListener('click', confirmHandler);
                modalCancel.removeEventListener('click', cancelHandler);
                resolve(false);
            }
        };
        document.addEventListener('keydown', escapeHandler);
    });
}

// Fonction pour rendre un champ readonly avec style
function makeFieldReadonly(fieldId, value) {
    const field = document.getElementById(fieldId);
    if (field && value) {
        field.value = value;
        field.readOnly = true;
        field.classList.add('bg-gray-100', 'cursor-not-allowed');
        field.classList.remove('border-gray-200', 'focus:ring-maxitOrange/60', 'focus:border-maxitOrange');
        field.classList.add('border-gray-300');
    }
}

// Fonction pour réinitialiser un champ
function resetField(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.value = '';
        field.readOnly = false;
        field.classList.remove('bg-gray-100', 'cursor-not-allowed', 'border-gray-300');
        field.classList.add('border-gray-200', 'focus:ring-maxitOrange/60', 'focus:border-maxitOrange');
    }
}

document.getElementById('cni').addEventListener('input', async function () {
    const cni = this.value.trim();
    const cniAlert = document.getElementById('cniAlert');
    const cniLoading = document.getElementById('cniLoading');
    const cniSuccess = document.getElementById('cniSuccess');
    
    // Masquer tous les messages
    cniAlert.classList.add('hidden');
    cniLoading.classList.add('hidden');
    cniSuccess.classList.add('hidden');
    
    if (cni.length === 13) {
        // Afficher le loading
        cniLoading.classList.remove('hidden');
        
        try {
            // Appel à votre API
            const response = await fetch(`https://appdaf-g15c.onrender.com/api/citoyen/${cni}`);
            const citoyen = await response.json();
            
            // Masquer le loading
            cniLoading.classList.add('hidden');
            
            if (!citoyen || citoyen.code !== 200 || !citoyen.data) {
                cniAlert.classList.remove('hidden');
            } else {
                // Afficher le succès
                cniSuccess.classList.remove('hidden');
                
                // Pré-remplir les champs avec les données récupérées et les rendre readonly
                console.log("Données récupérées :", citoyen);
                
                // Utiliser la structure exacte de votre API
                const data = citoyen.data;
                const prenomValue = data.prenom || '';
                const nomValue = data.nom || '';
                const emailValue = data.email || ''; // Pas dans les données, mais on garde au cas où
                const telephoneValue = data.telephone || data.phone || ''; // Pas dans les données actuelles
                
                // Remplir et bloquer les champs concernés
                if (prenomValue) makeFieldReadonly('prenom', prenomValue);
                if (nomValue) makeFieldReadonly('nom', nomValue);
                if (emailValue) makeFieldReadonly('login', emailValue);
                if (telephoneValue) makeFieldReadonly('telephone', telephoneValue);
                
                // Rendre le champ CNI readonly aussi
                makeFieldReadonly('cni', cni);
                
                // Afficher les données dans la console pour debug
                console.log("Structure de l'API:", citoyen);
                console.log("Données extraites:", data);
                console.log("Champs remplis:", {
                    prenom: prenomValue,
                    nom: nomValue,
                    email: emailValue,
                    telephone: telephoneValue,
                    date_naissance: data.date,
                    lieu_naissance: data.lieu,
                    carte_recto: data.url_carte_recto,
                    carte_verso: data.url_carte_verso
                });
                
                // Optionnel : Afficher un popup avec toutes les infos récupérées
                await showCustomPopup(
                    'Informations récupérées',
                    `Citoyen: ${prenomValue} ${nomValue}\nNé(e) le: ${data.date || 'Non disponible'}\nLieu: ${data.lieu || 'Non disponible'}`,
                    'info'
                );
            }
        } catch (error) {
            console.error("Erreur lors de la récupération :", error);
            cniLoading.classList.add('hidden');
            cniAlert.classList.remove('hidden');
        }
    } else if (cni.length === 0) {
        // Si le champ CNI est vidé, réinitialiser tous les champs
        resetField('nom');
        resetField('prenom');
        resetField('login');
        resetField('telephone');
        resetField('cni');
    }
});

// Fonction pour réinitialiser le formulaire si l'utilisateur modifie le CNI
document.getElementById('cni').addEventListener('focus', async function() {
    if (this.readOnly) {
        const shouldReset = await showCustomPopup(
            'Modifier le CNI',
            'Voulez-vous modifier le numéro CNI ? Cela effacera toutes les informations pré-remplies.',
            'warning',
            true
        );
        
        if (shouldReset) {
            // Réinitialiser tous les champs
            resetField('nom');
            resetField('prenom');
            resetField('login');
            resetField('telephone');
            resetField('cni');
            
            // Masquer les messages
            document.getElementById('cniAlert').classList.add('hidden');
            document.getElementById('cniSuccess').classList.add('hidden');
            document.getElementById('cniLoading').classList.add('hidden');
            
            // Remettre le focus sur le champ CNI
            setTimeout(() => this.focus(), 100);
        }
    }
});

// Empêcher la modification des champs readonly avec popup
document.addEventListener('keydown', async function(e) {
    if (e.target.readOnly && e.target.id !== 'cni') {
        e.preventDefault();
        await showCustomPopup(
            'Champ protégé',
            'Ce champ a été pré-rempli automatiquement. Pour le modifier, vous devez d\'abord changer le numéro CNI.',
            'info'
        );
    }
});

// Empêcher le clic sur les champs readonly
document.addEventListener('click', async function(e) {
    if (e.target.readOnly && e.target.id !== 'cni' && e.target.tagName === 'INPUT') {
        await showCustomPopup(
            'Champ protégé',
            'Ce champ a été pré-rempli automatiquement. Pour le modifier, cliquez sur le champ CNI.',
            'info'
        );
    }
});
</script>

</body>