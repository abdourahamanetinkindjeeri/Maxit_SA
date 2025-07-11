<?php
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];
$loginError = $_SESSION['login_error'] ?? null;

//unset($_SESSION['errors']);
//unset($_SESSION['old_input']);
//unset($_SESSION['login_error']);
?>

<!--<!DOCTYPE html>-->
<!--<html lang="fr">-->
<!--<head>-->
<!--    <meta charset="UTF-8" />-->
<!--    <title>Connexion Maxit Sénégal</title>-->
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
<!--<body class="bg-gradient-to-br from-maxitOrange/80 via-maxitGray to-maxitOrangeDark/70 min-h-screen flex items-center justify-center">-->

<div class="bg-white/90 rounded-2xl shadow-maxit p-8 w-full max-w-md backdrop-blur-md">

    <div class="flex flex-col items-center mb-6">
        <div class="w-16 h-16 rounded-full bg-maxitOrange flex items-center justify-center mb-2 shadow-lg">
            <span class="text-white text-3xl font-black">M</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-maxitOrange mb-1 tracking-tight">
            Connexion
        </h2>
        <p class="text-gray-500 text-sm">Accédez à votre espace Maxit Sénégal</p>
    </div>
    <!-- Message d'erreur général (identifiant incorrect) -->
    <?php if (!empty($loginError)): ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700 text-sm font-medium"><?= htmlspecialchars($loginError) ?></span>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4" action="<?php echo BASE_URL; ?>login">
        <div>
            <label class="block text-gray-700 font-semibold mb-1" for="login">Login</label>
            <input
                    id="login"
                    name="login"
                    type="text"
                    value="<?= htmlspecialchars($oldInput['login'] ?? '') ?>"
                    class="w-full border rounded-lg px-3 py-2 transition
                <?= isset($errors['login']) || (!empty($loginError) && strpos(strtolower($loginError), 'identifiant') !== false)
                        ? 'border-red-500 focus:ring-red-500 bg-red-50'
                        : 'border-gray-300 focus:ring-maxitOrange/60 focus:border-maxitOrange'
                    ?>
                focus:outline-none focus:ring-2"
                    placeholder="votreemail@gmail.com"
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

        <div>
            <label class="block text-gray-700 font-semibold mb-1" for="password">Mot de passe</label>
            <input
                    id="password"
                    name="password"
                    type="password"
                    value="<?= htmlspecialchars($oldInput['password'] ?? '') ?>"
                    class="w-full border rounded-lg px-3 py-2 transition
                <?= isset($errors['password']) || (!empty($loginError) && strpos(strtolower($loginError), 'mot de passe') !== false)
                        ? 'border-red-500 focus:ring-red-500 bg-red-50'
                        : 'border-gray-300 focus:ring-maxitOrange/60 focus:border-maxitOrange'
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

        <button
                type="submit"
                class="w-full bg-maxitOrange text-white font-bold py-2 rounded-lg shadow hover:bg-white hover:text-maxitOrange hover:border hover:border-maxitOrange transition-all duration-200 text-lg mt-6"
        >
            Se connecter
        </button>
    </form>

    <p class="mt-6 text-center text-gray-500 text-sm">
        Pas encore de compte ?
        <a href="<?php echo BASE_URL; ?>signup" class="text-maxitOrange font-semibold hover:underline">Inscrivez-vous</a>
    </p>
</div>

<!--</body>-->
<!--</html>-->