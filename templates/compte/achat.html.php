<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Woyofal - Maxitsa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #dc2626 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .shadow-custom {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <!-- Container principal -->
    <div class="w-full max-w-4xl">
        <!-- Header avec titre et description -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4">
                <i class="fas fa-bolt text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Paiement Woyofal</h1>
            <p class="text-white/90 text-lg max-w-2xl mx-auto">
                Effectuez vos paiements de facture d'électricité en toute simplicité et sécurité
            </p>
        </div>

        <!-- Carte principale -->
        <div class="glass-effect rounded-3xl shadow-custom p-8 max-w-2xl mx-auto">
            <!-- Informations importantes -->
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-orange-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold text-orange-800">Informations importantes</h3>
                        <p class="text-orange-700 text-sm mt-1">
                            Assurez-vous d'avoir le bon numéro de compteur et le montant exact de votre facture.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bouton d'ouverture du formulaire -->
            <div class="text-center">
                <button onclick="openAchatPopup()" 
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-lg rounded-xl shadow-lg hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-credit-card mr-3"></i>
                    Payer ma facture Woyofal
                </button>
            </div>

            <!-- Avantages -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="text-center p-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Paiement sécurisé</h3>
                    <p class="text-gray-600 text-sm">Transactions protégées et chiffrées</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-bolt text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Traitement instantané</h3>
                    <p class="text-gray-600 text-sm">Code de recharge immédiat</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-receipt text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Reçu détaillé</h3>
                    <p class="text-gray-600 text-sm">Justificatif complet de paiement</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- Popup Formulaire Achat -->
    <div id="achat-popup" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto transform transition-all duration-300">
            <!-- Header du popup -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-credit-card mr-3 text-xl"></i>
                        <h3 class="text-xl font-bold">Paiement Woyofal</h3>
                    </div>
                    <button onclick="closeAchatPopup()" class="text-white/80 hover:text-white text-2xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Contenu du formulaire -->
            <div class="p-6">
                <form id="achat-form" class="space-y-6">
                    <div>
                        <label for="compteur" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-hashtag mr-2 text-orange-500"></i>
                            Numéro de compteur
                        </label>
                        <input type="text" id="compteur" name="compteur" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               placeholder="Ex: CPT000000001">
                    </div>
                    
                    <div>
                        <label for="montant" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave mr-2 text-orange-500"></i>
                            Montant (FCFA)
                        </label>
                        <input type="number" id="montant" name="montant" required min="1000"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               placeholder="Ex: 5000">
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex gap-3 pt-4">
                        <button type="button" 
                                onclick="closeAchatPopup()"
                                class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-red-600 transition-all transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>
                            Valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup Reçu -->
    <div id="recu-popup" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto transform transition-all duration-300">
            <!-- Header du reçu -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-xl"></i>
                        <h3 class="text-xl font-bold">Paiement réussi !</h3>
                    </div>
                    <button onclick="closeRecu()" class="text-white/80 hover:text-white text-2xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Contenu du reçu -->
            <div class="p-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800 font-semibold">Transaction effectuée avec succès</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Client</label>
                            <p id="client" class="text-gray-800 font-medium"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Compteur</label>
                            <p id="compteur_recu" class="text-gray-800 font-medium"></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Référence</label>
                            <p id="reference" class="text-gray-800 font-medium"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Code recharge</label>
                            <p id="code" class="text-gray-800 font-medium break-all"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">KWT achetés</label>
                            <p id="nbreKwt" class="text-gray-800 font-medium"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Date</label>
                            <p id="date" class="text-gray-800 font-medium"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tranche</label>
                            <p id="tranche" class="text-gray-800 font-medium"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Prix unitaire</label>
                            <p id="prix" class="text-gray-800 font-medium"></p>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex gap-3 mt-6">
                    <button onclick="printRecu()" 
                            class="flex-1 px-4 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-print mr-2"></i>
                        Imprimer
                    </button>
                    <button onclick="closeRecu()" 
                            class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup d'alerte -->
    <div id="alert-popup" class="fixed inset-0 flex items-center justify-center p-4 hidden z-60">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-auto transform transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div id="alert-icon" class="flex-shrink-0 mr-3"></div>
                    <h3 id="alert-title" class="text-lg font-semibold"></h3>
                </div>
                <p id="alert-message" class="text-gray-600 mb-6"></p>
                <div id="alert-actions" class="flex justify-end">
                    <button onclick="closeAlert()" 
                            class="px-6 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration avec URL PHP
        const API_BASE_URL = "<?= BASE_URL ?>";

        function showAlert(message, type = "info", title = "", showRechargeButton = false) {
            const popup = document.getElementById("alert-popup");
            const overlay = document.getElementById("overlay");
            const alertIcon = document.getElementById("alert-icon");
            const alertTitle = document.getElementById("alert-title");
            const alertMessage = document.getElementById("alert-message");
            const alertActions = document.getElementById("alert-actions");

            // Configuration des icônes et couleurs selon le type
            switch (type) {
                case "error":
                    alertIcon.innerHTML = `
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>`;
                    alertTitle.textContent = title || "Erreur";
                    alertTitle.className = "text-lg font-semibold text-red-800";
                    break;
                case "success":
                    alertIcon.innerHTML = `
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>`;
                    alertTitle.textContent = title || "Succès";
                    alertTitle.className = "text-lg font-semibold text-green-800";
                    break;
                case "warning":
                    alertIcon.innerHTML = `
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>`;
                    alertTitle.textContent = title || "Attention";
                    alertTitle.className = "text-lg font-semibold text-yellow-800";
                    break;
                default: // info
                    alertIcon.innerHTML = `
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>`;
                    alertTitle.textContent = title || "Information";
                    alertTitle.className = "text-lg font-semibold text-blue-800";
            }

            alertMessage.textContent = message;

            // Gérer les boutons d'action
            if (showRechargeButton) {
                alertActions.innerHTML = `
                    <button onclick="rechargerCompte()" 
                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors mr-2">
                        <i class="fas fa-credit-card mr-2"></i>Recharger via OM
                    </button>
                    <button onclick="closeAlert()" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                `;
            } else {
                alertActions.innerHTML = `
                    <button onclick="closeAlert()" 
                            class="px-6 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors">
                        OK
                    </button>
                `;
            }

            showPopup(popup, overlay);
        }

        function rechargerCompte() {
            closeAlert();
            // Rediriger vers la page de recharge ou ouvrir un popup de recharge
            window.location.href = "<?= BASE_URL ?>compte/depot";
        }

        function closeAlert() {
            const popup = document.getElementById("alert-popup");
            const overlay = document.getElementById("overlay");
            hidePopup(popup, overlay);
        }

        function openAchatPopup() {
            const popup = document.getElementById("achat-popup");
            const overlay = document.getElementById("overlay");
            showPopup(popup, overlay);
            document.getElementById("compteur").focus();
        }

        function closeAchatPopup() {
            const popup = document.getElementById("achat-popup");
            const overlay = document.getElementById("overlay");
            hidePopup(popup, overlay);
            document.getElementById("achat-form").reset();
        }

        function closeRecu() {
            const popup = document.getElementById("recu-popup");
            const overlay = document.getElementById("overlay");
            hidePopup(popup, overlay);
        }

        function showRecu() {
            const popup = document.getElementById("recu-popup");
            const overlay = document.getElementById("overlay");
            showPopup(popup, overlay);
        }

        function showPopup(popup, overlay) {
            popup.classList.remove("hidden");
            overlay.classList.remove("hidden");
            
            // Force reflow
            popup.offsetHeight;
            
            popup.classList.add("opacity-100");
            popup.classList.remove("opacity-0");
        }

        function hidePopup(popup, overlay) {
            popup.classList.remove("opacity-100");
            popup.classList.add("opacity-0");
            
            setTimeout(() => {
                popup.classList.add("hidden");
                overlay.classList.add("hidden");
            }, 300);
        }

        function printRecu() {
            // Récupérer les données du reçu
            const client = document.getElementById("client").textContent;
            const compteur = document.getElementById("compteur_recu").textContent;
            const reference = document.getElementById("reference").textContent;
            const code = document.getElementById("code").textContent;
            const nbreKwt = document.getElementById("nbreKwt").textContent;
            const date = document.getElementById("date").textContent;
            const tranche = document.getElementById("tranche").textContent;
            const prix = document.getElementById("prix").textContent;

            const printWindow = window.open("", "_blank", "width=600,height=800");

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <title>Reçu d'achat Woyofal</title>
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            padding: 40px 20px; 
                            max-width: 500px; 
                            margin: 0 auto;
                            line-height: 1.6;
                            background: white;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 3px solid #10b981;
                            padding-bottom: 15px;
                        }
                        .header h1 {
                            color: #10b981;
                            margin: 0;
                            font-size: 24px;
                            font-weight: bold;
                        }
                        .header p {
                            color: #6b7280;
                            margin: 5px 0 0 0;
                            font-size: 14px;
                        }
                        .success-box {
                            background: #d1fae5;
                            border: 1px solid #10b981;
                            border-radius: 8px;
                            padding: 15px;
                            margin-bottom: 25px;
                            text-align: center;
                        }
                        .success-box .icon {
                            color: #10b981;
                            font-size: 20px;
                            margin-right: 8px;
                        }
                        .success-box .text {
                            color: #065f46;
                            font-weight: bold;
                        }
                        .details {
                            background: #f9fafb;
                            border: 1px solid #e5e7eb;
                            border-radius: 8px;
                            padding: 20px;
                        }
                        .detail-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 12px;
                            padding-bottom: 8px;
                            border-bottom: 1px solid #f3f4f6;
                        }
                        .detail-row:last-child {
                            border-bottom: none;
                            margin-bottom: 0;
                        }
                        .detail-label {
                            font-weight: bold;
                            color: #374151;
                            min-width: 120px;
                        }
                        .detail-value {
                            color: #6b7280;
                            text-align: right;
                            flex: 1;
                        }
                        .footer {
                            margin-top: 30px;
                            text-align: center;
                            color: #6b7280;
                            font-size: 12px;
                            border-top: 1px solid #e5e7eb;
                            padding-top: 15px;
                        }
                        @media print {
                            body { 
                                padding: 20px; 
                                background: white;
                            }
                            .header h1 { font-size: 20px; }
                            .details { background: white; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Reçu d'achat Woyofal</h1>
                        <p>Paiement de facture d'électricité</p>
                    </div>
                    
                    <div class="success-box">
                        <span class="icon">✓</span>
                        <span class="text">Transaction effectuée avec succès</span>
                    </div>
                    
                    <div class="details">
                        <div class="detail-row">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">${client}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Compteur:</span>
                            <span class="detail-value">${compteur}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Référence:</span>
                            <span class="detail-value">${reference}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Code recharge:</span>
                            <span class="detail-value">${code}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">KWT achetés:</span>
                            <span class="detail-value">${nbreKwt}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">${date}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tranche:</span>
                            <span class="detail-value">${tranche}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Prix unitaire:</span>
                            <span class="detail-value">${prix}</span>
                        </div>
                    </div>
                    
                    <div class="footer">
                        <p>Merci d'avoir utilisé Maxitsa pour votre paiement Woyofal</p>
                        <p>Ce reçu fait foi de paiement</p>
                    </div>
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();

            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }

        // Fermer les popups en cliquant sur l'overlay
        document.getElementById("overlay").addEventListener("click", function() {
            if (!document.getElementById("achat-popup").classList.contains("hidden")) {
                closeAchatPopup();
            } else if (!document.getElementById("recu-popup").classList.contains("hidden")) {
                closeRecu();
            } else if (!document.getElementById("alert-popup").classList.contains("hidden")) {
                closeAlert();
            }
        });

        // Fermer avec la touche Échap
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                if (!document.getElementById("achat-popup").classList.contains("hidden")) {
                    closeAchatPopup();
                } else if (!document.getElementById("recu-popup").classList.contains("hidden")) {
                    closeRecu();
                } else if (!document.getElementById("alert-popup").classList.contains("hidden")) {
                    closeAlert();
                }
            }
        });

        // Gestion du formulaire
        document.getElementById("achat-form").addEventListener("submit", async function(e) {
            e.preventDefault();

            const compteur = document.getElementById("compteur").value.trim();
            const montant = parseFloat(document.getElementById("montant").value);

            // Validation côté client
            if (!compteur) {
                showAlert("Veuillez saisir un numéro de compteur valide.", "error", "Champ requis");
                return;
            }

            if (!montant || montant <= 0) {
                showAlert("Veuillez saisir un montant valide.", "error", "Montant invalide");
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(`${API_BASE_URL}achat/process`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ compteur, montant }),
                });

                const result = await response.json();
                
                if (result.statut === "success" && result.data) {
                    // Remplir les données du reçu avec une gestion sécurisée des valeurs nulles
                    const data = result.data;
                    const client = data.client || {};
                    const compteurData = data.compteur || {};
                    const tranche = data.tranche || {};

                    document.getElementById("client").textContent = 
                        `${client.nom || ""} ${client.prenom || ""}`.trim() || "N/A";
                    document.getElementById("compteur_recu").textContent = 
                        compteurData.numero || compteur;
                    document.getElementById("reference").textContent = 
                        data.reference || "N/A";
                    document.getElementById("code").textContent = 
                        data.codeRecharge || "N/A";
                    document.getElementById("nbreKwt").textContent = data.nbreKwt 
                        ? `${data.nbreKwt} KWT` 
                        : "N/A";
                    document.getElementById("date").textContent = 
                        data.date || new Date().toLocaleDateString("fr-FR");
                    document.getElementById("tranche").textContent = 
                        tranche.nom || "N/A";
                    document.getElementById("prix").textContent = tranche.prixParKwh 
                        ? `${tranche.prixParKwh} FCFA/KWT` 
                        : "N/A";

                    // Fermer le popup d'achat et ouvrir le reçu
                    closeAchatPopup();
                    setTimeout(() => {
                        showRecu();
                    }, 300);
                } else if (result.statut === "insufficient_balance") {
                    // Afficher le message de solde insuffisant avec option de recharge
                    showAlert(
                        `Solde insuffisant. Votre solde actuel: ${result.solde_actuel} FCFA. Montant demandé: ${result.montant_demande} FCFA. Montant manquant: ${result.montant_manquant} FCFA. ${result.message}`,
                        "warning",
                        "Solde insuffisant",
                        true // Afficher le bouton de recharge
                    );
                } else {
                    showAlert(
                        result.error || result.message || "Erreur lors de l'achat",
                        "error",
                        "Échec de la transaction"
                    );
                }
            } catch (error) {
                console.error("Erreur:", error);
                showAlert(
                    "Erreur de connexion. Veuillez réessayer.",
                    "error",
                    "Problème de connexion"
                );
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
