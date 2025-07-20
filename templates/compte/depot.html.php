<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dépôt entre comptes - Maxit Sénégal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Dépôt entre mes comptes</h1>
        <?php if (!empty($_SESSION['depot_success'])): ?>
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo htmlspecialchars($_SESSION['depot_success']); unset($_SESSION['depot_success']); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['depot_error'])): ?>
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?php echo htmlspecialchars($_SESSION['depot_error']); unset($_SESSION['depot_error']); ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Compte courant (source)</label>
                <?php foreach ($comptes as $compte): ?>
                    <?php if ($compte->getId() == $compte_courant_id): ?>
                        <input type="text" value="<?php echo htmlspecialchars($compte->getTelephone()) . ' (Solde: ' . number_format($compte->getMontant(), 0, ',', ' ') . ' FCFA)'; ?>" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="mb-4">
                <label for="cible_compte_id" class="block text-gray-700 font-semibold mb-2">Compte à alimenter (cible)</label>
                <select name="cible_compte_id" id="cible_compte_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Sélectionnez un compte</option>
                    <?php foreach ($comptes as $compte): ?>
                        <?php if ($compte->getId() != $compte_courant_id): ?>
                            <option value="<?php echo $compte->getId(); ?>">
                                <?php echo htmlspecialchars($compte->getTelephone()) . ' (Solde: ' . number_format($compte->getMontant(), 0, ',', ' ') . ' FCFA)'; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="montant" class="block text-gray-700 font-semibold mb-2">Montant à déposer</label>
                <input type="number" name="montant" id="montant" min="1" step="0.01" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-maxitOrange text-white font-semibold py-2 rounded hover:bg-maxitOrangeLight transition">Déposer</button>
        </form>
        <div class="mt-6 text-center">
            <a href="<?php echo BASE_URL; ?>compte" class="text-maxitOrange hover:underline">Retour à mon compte</a>
        </div>
    </div>
</body>
</html> 