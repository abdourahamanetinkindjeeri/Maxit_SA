<?php
$filter_date = $_GET['filter_date'] ?? '';
$filter_type = $_GET['filter_type'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptes - Maxit Sénégal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
            <a href="<?php echo BASE_URL; ?>achat" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition">
              <i class='bx bx-credit-card text-xl mr-3'></i>
              Paiement Woyofal
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
            <a href="<?php echo BASE_URL; ?>logout"" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition">
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
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Mon Compte</h1>
        <div class="flex space-x-2">
            <button id="btnAddSecondary" class="bg-maxitOrange text-white px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight transition font-semibold" title="Ajouter un compte secondaire">
                <i class='bx bx-user-plus text-xl'></i>
            </button>
            <a href="<?php echo BASE_URL; ?>compte/depot" class="bg-maxitOrange text-white px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight transition font-semibold flex items-center" title="Déposer">
                <i class='bx bx-plus-circle text-xl'></i>
            </a>
            <a href="#" id="btnChangeAccount" class="bg-white text-maxitOrange font-semibold px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight hover:text-white transition flex items-center" title="Changer de compte">
                <i class='bx bx-transfer text-xl'></i>
            </a>
        </div>
    </div>

    <!-- Bouton d'accès rapide Woyofal -->
    <div class="mb-6">
        <a href="<?php echo BASE_URL; ?>achat" 
           class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-lg rounded-xl shadow-lg hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300">
            <i class='bx bx-credit-card text-2xl mr-3'></i>
            Payer ma facture Woyofal
        </a>
    </div>
    <?php if (!empty($_SESSION['add_secondary_errors'])): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?php foreach ($_SESSION['add_secondary_errors'] as $err): ?>
                <div><?php echo htmlspecialchars($err); ?></div>
            <?php endforeach; unset($_SESSION['add_secondary_errors']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['add_secondary_success'])): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo htmlspecialchars($_SESSION['add_secondary_success']); unset($_SESSION['add_secondary_success']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['change_account_success'])): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo htmlspecialchars($_SESSION['change_account_success']); unset($_SESSION['change_account_success']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['change_account_errors'])): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?php foreach ($_SESSION['change_account_errors'] as $err): ?>
                <div><?php echo htmlspecialchars($err); ?></div>
            <?php endforeach; unset($_SESSION['change_account_errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Modal d'ajout de compte secondaire -->
    <div id="modalAddSecondary" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button id="closeModalAddSecondary" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-800">Ajouter un compte secondaire</h2>
            <form method="post" action="<?php echo BASE_URL; ?>compte/ajouter-secondaire">
                <div class="mb-4">
                    <label for="numero" class="block text-gray-700 font-semibold mb-2">Numéro du compte secondaire <span class="text-red-500">*</span></label>
                    <input type="text" id="numero" name="numero" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-maxitOrange">
                </div>
                <div class="mb-4">
                    <label for="solde" class="block text-gray-700 font-semibold mb-2">Solde initial (optionnel)</label>
                    <input type="number" id="solde" name="solde" min="0" step="0.01" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-maxitOrange">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-maxitOrange text-white px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight transition font-semibold">Créer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal de changement de compte -->
    <div id="modalChangeAccount" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">

            <button id="closeModalChangeAccount" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-800">Changer de compte</h2>
            <form method="post" action="<?php echo BASE_URL; ?>compte/changer-compte">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Sélectionnez un numéro :</label>
                    <select name="compte_id" id="compteSelect" class="w-full border rounded px-3 py-2" required>
                        <option value="">Chargement des comptes...</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-maxitOrange text-white px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight transition font-semibold">Valider</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const btnAddSecondary = document.getElementById('btnAddSecondary');
        const modalAddSecondary = document.getElementById('modalAddSecondary');
        const closeModalAddSecondary = document.getElementById('closeModalAddSecondary');
        btnAddSecondary.addEventListener('click', () => {
            modalAddSecondary.classList.remove('hidden');
        });
        closeModalAddSecondary.addEventListener('click', () => {
            modalAddSecondary.classList.add('hidden');
        });
        window.addEventListener('click', (e) => {
            if (e.target === modalAddSecondary) {
                modalAddSecondary.classList.add('hidden');
            }
        });

        const btnChangeAccount = document.getElementById('btnChangeAccount');
        const modalChangeAccount = document.getElementById('modalChangeAccount');
        const closeModalChangeAccount = document.getElementById('closeModalChangeAccount');
        const compteSelect = document.getElementById('compteSelect');
        
        btnChangeAccount.addEventListener('click', () => {
            modalChangeAccount.classList.remove('hidden');
            // Charger les comptes quand le modal s'ouvre
            loadComptes();
        });
        
        closeModalChangeAccount.addEventListener('click', () => {
            modalChangeAccount.classList.add('hidden');
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === modalChangeAccount) {
                modalChangeAccount.classList.add('hidden');
            }
        });
        
        // Fonction pour charger les comptes via AJAX
        function loadComptes() {
            fetch('<?php echo BASE_URL; ?>compte/get-comptes-ajax')
                .then(response => response.json())
                .then(data => {
                    if (data.comptes && data.comptes.length > 0) {
                        compteSelect.innerHTML = '<option value="">Sélectionnez un compte</option>';
                        data.comptes.forEach(compte => {
                            const option = document.createElement('option');
                            option.value = compte.id;
                            option.textContent = compte.telephone + (compte.isPrincipal ? ' (principal)' : '');
                            compteSelect.appendChild(option);
                        });
                    } else {
                        compteSelect.innerHTML = '<option value="">Aucun compte disponible</option>';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des comptes:', error);
                    compteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        }
    </script>
    <!-- Solde de l'utilisateur connecté -->
    <div id="soldeSection" class="bg-gradient-to-r from-maxitOrange to-maxitOrangeLight rounded-xl shadow-maxit p-6 mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-white mb-1">Mon solde</h3>
            <div id="soldeMontant" class="text-3xl font-bold text-white">
              <?php echo isset(
                $solde) ? number_format($solde, 0, ',', ' ') . ' FCFA' : '0 FCFA'; ?>
            </div>
            <p class="text-xs text-orange-100 mt-1">Téléphone : <span class="font-bold"><?php echo htmlspecialchars($telephone ?? ''); ?></span></p>
            <p class="text-xs text-orange-100 mt-1">Mis à jour le <span id="dateUpdate"></span></p>
        </div>
        <div class="flex items-center space-x-4">
            <button id="toggleSolde" class="bg-white text-maxitOrange font-semibold px-5 py-2 rounded-lg shadow hover:bg-maxitOrangeLight hover:text-white transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Masquer le solde
            </button>
        </div>
    </div>

        <!-- Liste des transactions -->
        <div class="bg-white rounded-xl shadow-maxit p-8 w-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Historique des transactions</h2>
                <div class="flex items-center space-x-2">
                    <a href="<?php echo BASE_URL; ?>transactions" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded shadow text-sm inline-block">
                        Voir plus
                    </a>
                </div>
            </div>
            <form method="get" action="<?php echo BASE_URL; ?>compte" class="flex items-center space-x-4 mb-4">
    <div>
        <label for="filter_date" class="text-sm text-gray-700 mr-2">Date :</label>
        <input type="date" id="filter_date" name="filter_date" class="border rounded px-2 py-1 text-sm"
            value="<?php echo htmlspecialchars($filter_date ?? ''); ?>">
    </div>
    <div>
        <label for="filter_type" class="text-sm text-gray-700 mr-2">Type :</label>
        <select id="filter_type" name="filter_type" class="border rounded px-2 py-1 text-sm">
            <option value="">Tous</option>
            <option value="DEPOT" <?php if(($filter_type ?? '') == 'DEPOT') echo 'selected'; ?>>Dépôt</option>
            <option value="RETRAIT" <?php if(($filter_type ?? '') == 'RETRAIT') echo 'selected'; ?>>Retrait</option>
            <option value="PAIEMENT" <?php if(($filter_type ?? '') == 'PAIEMENT') echo 'selected'; ?>>Paiement</option>
        </select>
    </div>
    <button type="submit" class="bg-maxitOrange text-white px-4 py-2 rounded hover:bg-maxitOrangeLight text-sm">Filtrer</button>
    <?php if ($filter_date || $filter_type): ?>
        <a href="<?php echo BASE_URL; ?>compte" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">Réinitialiser</a>
    <?php endif; ?>
</form>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <?php if ($filter_date || $filter_type): ?>
                                        Aucune transaction trouvée avec les filtres sélectionnés.
                                    <?php else: ?>
                                        Aucune transaction disponible.
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $index => $transaction): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $index + 1; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium <?php 
                                        $type = $transaction['typeTransaction']->value ?? '';
                                        if ($type === 'DEPOT') {
                                            echo 'text-green-600';
                                        } elseif (in_array($type, ['RETRAIT', 'PAIEMENT'])) {
                                            echo 'text-red-600';
                                        } else {
                                            echo 'text-gray-800';
                                        }
                                    ?>">
                                        <?php 
                                        $type = $transaction['typeTransaction']->value ?? '';
                                        $montant = $transaction['montant'] ?? 0;
                                        if ($type === 'DEPOT') {
                                            echo '+' . number_format($montant, 0, ',', ' ') . ' FCFA';
                                        } elseif (in_array($type, ['RETRAIT', 'PAIEMENT'])) {
                                            echo '-' . number_format($montant, 0, ',', ' ') . ' FCFA';
                                        } else {
                                            echo number_format($montant, 0, ',', ' ') . ' FCFA';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full <?php 
                                            if ($type === 'DEPOT') {
                                                echo 'bg-green-100 text-green-800';
                                            } elseif ($type === 'RETRAIT') {
                                                echo 'bg-red-100 text-red-800';
                                            } elseif ($type === 'PAIEMENT') {
                                                echo 'bg-orange-100 text-orange-800';
                                            } else {
                                                echo 'bg-gray-100 text-gray-800';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($type); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php 
                                        $date = $transaction['date'] ?? '';
                                        if ($date instanceof \DateTime) {
                                            echo $date->format('d/m/Y H:i');
                                        } else {
                                            echo htmlspecialchars($date);
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Détails</a>
                                        <?php if (($transaction['typeTransaction']->value ?? '') === 'DEPOT' && ($transaction['statut'] ?? 'VALIDE') === 'VALIDE'): ?>
                                            <a href="<?php echo BASE_URL; ?>compte/annuler-depot?id=<?php echo $transaction['id']; ?>" class="ml-2 text-red-600 hover:text-red-800" onclick="return confirm('Annuler ce dépôt ?');">Annuler</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
          
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du toggle solde
    const toggleSoldeBtn = document.getElementById('toggleSolde');
    const soldeMontant = document.getElementById('soldeMontant');
    
    let soldeVisible = true;
    const soldeOriginal = soldeMontant.textContent;
    
    toggleSoldeBtn.addEventListener('click', function() {
        if (soldeVisible) {
            soldeMontant.textContent = '••••••••••••';
            toggleSoldeBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
                Afficher le solde
            `;
        } else {
            soldeMontant.textContent = soldeOriginal;
            toggleSoldeBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Masquer le solde
            `;
        }
        soldeVisible = !soldeVisible;
    });

    // Mettre à jour la date
    const dateUpdate = document.getElementById('dateUpdate');
    const now = new Date();
    dateUpdate.textContent = now.toLocaleDateString('fr-FR') + ' à ' + now.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});
});
</script>

</body>
</html>