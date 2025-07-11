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

<!--<!DOCTYPE html>-->
<!--<html lang="fr">-->
<!--<head>-->
<!--    <meta charset="UTF-8" />-->
<!--    <title>Inscription Maxit Sénégal</title>-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0" />-->
<!--    <script src="https://cdn.tailwindcss.com"></script>-->
<!--    <script>-->
<!--        tailwind.config = {-->
<!--            theme: {-->
<!--                extend: {-->
<!--                    colors: {-->
<!--                        maxitOrange: "#FF7900",-->
<!--                        maxitOrangeDark: "#FF6600",-->
<!--                        maxitGray: "#F5F7FA",-->
<!--                    },-->
<!--                    boxShadow: {-->
<!--                        maxit: "0 8px 32px 0 rgba(255,121,0,0.10)",-->
<!--                    },-->
<!--                },-->
<!--            },-->
<!--        };-->
<!--    </script>-->
<!--</head>-->
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

        <div class="flex gap-4">
            <div class="w-1/2">
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
            <div class="w-1/2">
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
                />
                <?php if (isset($errors['cni'])): ?>
                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                        <svg class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?= htmlspecialchars($errors['cni'][0]) ?>
                    </span>
                <?php endif; ?>
            </div>
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

</body>
<!--</html>-->