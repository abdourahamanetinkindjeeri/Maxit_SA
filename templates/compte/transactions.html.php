<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes les transactions - Maxit Sénégal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-maxitGray min-h-screen">
    <div class="container mx-auto py-8">
        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>compte" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded shadow text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Retour
            </a>
        </div>
        <h1 class="text-2xl font-bold mb-6">Toutes les transactions</h1>
        <div class="bg-white rounded-xl shadow-maxit p-8 w-full">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucune transaction disponible.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $index => $transaction): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo ($index + 1) + (($page-1)*10); ?></td>
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
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="flex justify-center mt-6">
                <?php if ($nbPages > 1): ?>
                    <nav class="inline-flex -space-x-px">
                        <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="px-3 py-2 border border-gray-300 <?php echo $i == $page ? 'bg-maxitOrange text-white' : 'bg-white text-gray-700'; ?> text-sm font-medium">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 