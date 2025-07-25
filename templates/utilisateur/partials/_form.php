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
        <!-- Champ CNI -->
        <?php include '_form_fields/cni.php'; ?>

        <!-- Champs Nom et Prénom -->
        <div class="flex gap-4">
            <?php include '_form_fields/nom_prenom.php'; ?>
        </div>

        <!-- Champs CNI Recto et Verso -->
        <div class="flex gap-4">
            <?php include '_form_fields/cni_images.php'; ?>
        </div>

        <!-- Champs Login et Mot de passe -->
        <div class="flex gap-4">
            <?php include '_form_fields/login_password.php'; ?>
        </div>

        <!-- Champ Téléphone -->
        <?php include '_form_fields/telephone.php'; ?>

        <button type="submit" class="w-full bg-maxitOrange text-white font-bold py-2 rounded-lg shadow hover:bg-white hover:text-maxitOrange hover:border hover:border-maxitOrange transition-all duration-200 text-lg mt-6">
            S'inscrire
        </button>
    </form>

    <p class="mt-6 text-center text-gray-500 text-sm">
        Déjà un compte ?
        <a href="<?php echo BASE_URL; ?>login" class="text-maxitOrange font-semibold hover:underline">Connectez-vous</a>
    </p>
</div> 