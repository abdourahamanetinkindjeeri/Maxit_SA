<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptes - Maxit Sénégal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maxitOrange: "#FF7900",
                        maxitOrangeLight: "#FF9F40",
                        maxitGray: "#F5F7FA",
                    },
                    boxShadow: {
                        maxit: "0 4px 20px 0 rgba(255,121,0,0.08)",
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-maxitGray min-h-screen">
<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 w-56 bg-white shadow-md border-r border-gray-200 z-20">
    <div class="p-6 bg-maxitOrangeLight">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3">
                <span class="text-maxitOrange text-lg font-bold">M</span>
            </div>
            <span class="text-white text-lg font-semibold">Maxit Sénégal</span>
        </div>
    </div>
    <nav class="mt-6 px-4">
        <div class="space-y-2">
            <a href="#" class="flex items-center px-4 py-3 text-white bg-maxitOrange rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Utilisateurs
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                Transactions
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Rapports
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Paramètres
            </a>
        </div>
    </nav>
    <div class="absolute bottom-4 left-4 right-4">
        <div class="space-y-2">
            <div class="bg-gray-100 rounded-lg p-3">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Système en ligne</span>
                </div>
                <p class="text-xs text-gray-600 mt-1">Dernière mise à jour: 14:30</p>
            </div>
            <a href="<?php echo BASE_URL; ?>logout" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Se déconnecter
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="ml-56 w-[calc(100%-14rem)] min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Mon compte</h1>
                <p class="text-sm text-gray-600">Bienvenue, <span class="font-semibold"><?php echo isset($user) ? htmlspecialchars($user['prenom'] . ' ' . $user['nom']) : 'Utilisateur'; ?></span></p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span>En ligne</span>
                </div>
                <button class="p-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5 5-5h-5m-6 0H4l5 5-5 5h5m6-10v4"></path>
                    </svg>
                </button>
                <a href="<?php echo BASE_URL; ?>compte/ajouter" class="bg-maxitOrange text-white px-4 py-2 rounded-lg hover:bg-maxitOrangeLight transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter un compte
                </a>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-maxitOrange flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                            <?php echo isset($user) ? strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)) : 'U'; ?>
                        </span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">
                        <?php echo isset($user) ? htmlspecialchars($user['prenom'] . ' ' . $user['nom']) : 'Utilisateur'; ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="p-0 pt-8 w-full">
        <!-- Solde de l'utilisateur connecté -->
        <div id="soldeSection" class="bg-gradient-to-r from-maxitOrange to-maxitOrangeLight rounded-xl shadow-maxit p-6 mb-8 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-white mb-1">Mon solde</h3>
                <div id="soldeMontant" class="text-3xl font-bold text-white">
                    <?php echo isset($solde) ? number_format($solde, 0, ',', ' ') . ' FCFA' : '0 FCFA'; ?>
                </div>
                <p class="text-xs text-orange-100 mt-1">Mis à jour le <?php echo date('d/m/Y à H:i'); ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <button id="toggleSolde" class="bg-white text-maxitOrange font-semibold px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight hover:text-white transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Voir le solde
                </button>
            </div>
        </div>

        <!-- Liste des comptes -->
        <div class="bg-white rounded-xl shadow-maxit p-8 w-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Historique</h2>
            </div>
            <?php if (!empty($comptes)) : ?>
                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphones</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        <?php foreach ($comptes as $index => $compte) : ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold"><?php echo $index + 1; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-maxitOrange flex items-center justify-center text-white font-bold mr-3">
                                        <?php echo strtoupper(substr($compte['nom'] ?? '', 0, 1)); ?>
                                    </div>
                                    <span class="text-gray-800 font-medium"><?php echo htmlspecialchars($compte['nom'] ?? ''); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php if (!empty($compte['telephones'])) : ?>
                                        <?php foreach ((array)$compte['telephones'] as $tel) : ?>
                                            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs mr-1 mb-1"><?php echo htmlspecialchars($tel); ?></span>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        <?php echo ($compte['type'] ?? '') === 'EPARGNE' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'; ?>">
                                        <?php echo htmlspecialchars($compte['type'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    <?php echo number_format($compte['solde'] ?? 0, 0, ',', ' ') . ' FCFA'; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        <?php echo ($compte['statut'] ?? '') === 'ACTIF' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                        <?php echo htmlspecialchars($compte['statut'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="<?php echo BASE_URL; ?>compte/voir?id=<?php echo $compte['id']; ?>" class="inline-block text-blue-600 hover:text-blue-900" title="Voir">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>compte/edit?id=<?php echo $compte['id']; ?>" class="inline-block text-yellow-500 hover:text-yellow-700" title="Éditer">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m-7-7h14" />
                                        </svg>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>compte/delete?id=<?php echo $compte['id']; ?>" class="inline-block text-red-600 hover:text-red-900" title="Supprimer" onclick="return confirm('Supprimer ce compte ?');">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center py-12">
                    <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Aucun compte trouvé</h3>
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore de compte enregistré.</p>
                    <a href="<?php echo BASE_URL; ?>compte/ajouter" class="bg-maxitOrange text-white px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight transition">+ Ajouter un compte</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleSoldeBtn = document.getElementById('toggleSolde');
    const soldeMontant = document.getElementById('soldeMontant');
    const soldeSection = document.getElementById('soldeSection');
    
    let soldeVisible = true;
    const soldeOriginal = soldeMontant.textContent;
    
    toggleSoldeBtn.addEventListener('click', function() {
        if (soldeVisible) {
            soldeMontant.textContent = '••••••••••••';
            toggleSoldeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" /></svg>';
            toggleSoldeBtn.title = 'Afficher le solde';
        } else {
            soldeMontant.textContent = soldeOriginal;
            toggleSoldeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            toggleSoldeBtn.title = 'Masquer le solde';
        }
        soldeVisible = !soldeVisible;
    });
});
</script>
