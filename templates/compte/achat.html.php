<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Achat Woyofal</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
      <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">
        Achat de crédit Woyofal
      </h2>
      <button
        class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300"
        onclick="openAchatPopup()"
      >
        Paiement Woyofal
      </button>
    </div>

    <!-- Overlay -->
    <div
      id="overlay"
      class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none z-40"
    ></div>

    <!-- Popup Formulaire Achat -->
    <div
      id="achat-popup"
      class="fixed inset-0 flex items-center justify-center p-4 transition-all duration-300 opacity-0 pointer-events-none z-50"
    >
      <div
        class="bg-white rounded-lg shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all duration-300 scale-95"
      >
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">
          Formulaire d'achat Woyofal
        </h3>
        <form id="achat-form" class="space-y-4">
          <div>
            <label
              for="compteur"
              class="block text-sm font-medium text-gray-700"
              >Numéro de compteur :</label
            >
            <input
              type="text"
              id="compteur"
              name="compteur"
              required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div>
            <label for="montant" class="block text-sm font-medium text-gray-700"
              >Montant :</label
            >
            <input
              type="number"
              id="montant"
              name="montant"
              min="1"
              required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div class="flex justify-end space-x-2">
            <button
              type="submit"
              class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Valider le paiement
            </button>
            <button
              type="button"
              class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-400 transition duration-300"
              onclick="closeAchatPopup()"
            >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Popup Alerte -->
    <div
      id="alert-popup"
      class="fixed inset-0 flex items-center justify-center p-4 transition-all duration-300 opacity-0 pointer-events-none z-60"
    >
      <div
        class="bg-white rounded-lg shadow-2xl p-6 max-w-sm w-full mx-auto transform transition-all duration-300 scale-95"
      >
        <div class="flex items-center mb-4">
          <div id="alert-icon" class="flex-shrink-0 mr-3"></div>
          <h3 id="alert-title" class="text-lg font-semibold text-gray-800"></h3>
        </div>
        <p id="alert-message" class="text-gray-600 mb-6"></p>
        <div class="flex justify-end">
          <button
            onclick="closeAlert()"
            class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300"
          >
            OK
          </button>
        </div>
      </div>
    </div>

    <!-- Popup reçu -->
    <div
      id="recu-popup"
      class="fixed inset-0 flex items-center justify-center p-4 transition-all duration-300 opacity-0 pointer-events-none z-50"
    >
      <div
        class="bg-white rounded-lg shadow-2xl p-6 max-w-md w-full mx-auto transform transition-all duration-300 scale-95"
      >
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Reçu d'achat</h3>
        <div id="recu-content" class="space-y-3">
          <p>
            <strong class="text-gray-700">Nom et Prénom :</strong>
            <span id="client" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Numéro de compteur :</strong>
            <span id="compteur_recu" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Référence :</strong>
            <span id="reference" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Code de recharge :</strong>
            <span id="code" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Nombre KWT :</strong>
            <span id="nbreKwt" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Date :</strong>
            <span id="date" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Tranche :</strong>
            <span id="tranche" class="text-gray-600"></span>
          </p>
          <p>
            <strong class="text-gray-700">Prix unitaire :</strong>
            <span id="prix" class="text-gray-600"></span>
          </p>
        </div>
        <div class="flex justify-end space-x-2 mt-6">
          <button
            onclick="printRecu()"
            class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300"
          >
            Imprimer
          </button>
          <button
            onclick="closeRecu()"
            class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-400 transition duration-300"
          >
            Fermer
          </button>
        </div>
      </div>
    </div>

    <script>
      // Configuration avec URL PHP
      const API_BASE_URL = "<?= BASE_URL ?>";

      function showAlert(message, type = "info", title = "") {
        const popup = document.getElementById("alert-popup");
        const overlay = document.getElementById("overlay");
        const alertIcon = document.getElementById("alert-icon");
        const alertTitle = document.getElementById("alert-title");
        const alertMessage = document.getElementById("alert-message");

        // Configuration des icônes et couleurs selon le type
        switch (type) {
          case "error":
            alertIcon.innerHTML = `
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>`;
            alertTitle.textContent = title || "Erreur";
            alertTitle.className = "text-lg font-semibold text-red-800";
            break;
          case "success":
            alertIcon.innerHTML = `
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>`;
            alertTitle.textContent = title || "Succès";
            alertTitle.className = "text-lg font-semibold text-green-800";
            break;
          case "warning":
            alertIcon.innerHTML = `
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>`;
            alertTitle.textContent = title || "Attention";
            alertTitle.className = "text-lg font-semibold text-yellow-800";
            break;
          default: // info
            alertIcon.innerHTML = `
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>`;
            alertTitle.textContent = title || "Information";
            alertTitle.className = "text-lg font-semibold text-blue-800";
        }

        alertMessage.textContent = message;

        popup.style.pointerEvents = "auto";
        overlay.style.pointerEvents = "auto";

        // Force reflow
        popup.offsetHeight;

        popup.classList.remove("opacity-0");
        popup.classList.add("opacity-100");
        popup.querySelector(".transform").classList.remove("scale-95");
        popup.querySelector(".transform").classList.add("scale-100");

        overlay.classList.remove("opacity-0");
        overlay.classList.add("opacity-100");
      }

      function closeAlert() {
        const popup = document.getElementById("alert-popup");
        const overlay = document.getElementById("overlay");

        popup.classList.remove("opacity-100");
        popup.classList.add("opacity-0");
        popup.querySelector(".transform").classList.remove("scale-100");
        popup.querySelector(".transform").classList.add("scale-95");

        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");

        setTimeout(() => {
          popup.style.pointerEvents = "none";
          overlay.style.pointerEvents = "none";
        }, 300);
      }

      function openAchatPopup() {
        const popup = document.getElementById("achat-popup");
        const overlay = document.getElementById("overlay");

        popup.style.pointerEvents = "auto";
        overlay.style.pointerEvents = "auto";

        // Force reflow
        popup.offsetHeight;

        popup.classList.remove("opacity-0");
        popup.classList.add("opacity-100");
        popup.querySelector(".transform").classList.remove("scale-95");
        popup.querySelector(".transform").classList.add("scale-100");

        overlay.classList.remove("opacity-0");
        overlay.classList.add("opacity-100");

        // Focus sur le premier input
        document.getElementById("compteur").focus();
      }

      function closeAchatPopup() {
        const popup = document.getElementById("achat-popup");
        const overlay = document.getElementById("overlay");

        popup.classList.remove("opacity-100");
        popup.classList.add("opacity-0");
        popup.querySelector(".transform").classList.remove("scale-100");
        popup.querySelector(".transform").classList.add("scale-95");

        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");

        setTimeout(() => {
          popup.style.pointerEvents = "none";
          overlay.style.pointerEvents = "none";
        }, 300);

        // Reset form
        document.getElementById("achat-form").reset();
      }

      function closeRecu() {
        const popup = document.getElementById("recu-popup");
        const overlay = document.getElementById("overlay");

        popup.classList.remove("opacity-100");
        popup.classList.add("opacity-0");
        popup.querySelector(".transform").classList.remove("scale-100");
        popup.querySelector(".transform").classList.add("scale-95");

        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");

        setTimeout(() => {
          popup.style.pointerEvents = "none";
          overlay.style.pointerEvents = "none";
        }, 300);
      }

      function showRecu() {
        const popup = document.getElementById("recu-popup");
        const overlay = document.getElementById("overlay");

        popup.style.pointerEvents = "auto";
        overlay.style.pointerEvents = "auto";

        // Force reflow
        popup.offsetHeight;

        popup.classList.remove("opacity-0");
        popup.classList.add("opacity-100");
        popup.querySelector(".transform").classList.remove("scale-95");
        popup.querySelector(".transform").classList.add("scale-100");

        overlay.classList.remove("opacity-0");
        overlay.classList.add("opacity-100");
      }

      function printRecu() {
        const recuContent = document.getElementById("recu-content").innerHTML;
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
              }
              h1 {
                text-align: center;
                color: #1f2937;
                margin-bottom: 30px;
                border-bottom: 2px solid #3b82f6;
                padding-bottom: 10px;
              }
              .recu-content p { 
                margin: 15px 0; 
                font-size: 14px;
              }
              .recu-content strong { 
                color: #374151; 
                display: inline-block;
                min-width: 140px;
              }
              .recu-content span {
                color: #6b7280;
              }
              @media print {
                body { padding: 20px; }
                h1 { font-size: 18px; }
              }
            </style>
          </head>
          <body>
            <h1>Reçu d'achat Woyofal</h1>
            <div class="recu-content">${recuContent}</div>
          </body>
        </html>
      `);

        printWindow.document.close();
        printWindow.focus();

        // Attendre que le contenu soit chargé avant d'imprimer
        setTimeout(() => {
          printWindow.print();
          printWindow.close();
        }, 250);
      }

      // Fermer les popups en cliquant sur l'overlay
      document.getElementById("overlay").addEventListener("click", function () {
        if (
          !document
            .getElementById("achat-popup")
            .classList.contains("opacity-0")
        ) {
          closeAchatPopup();
        } else if (
          !document.getElementById("recu-popup").classList.contains("opacity-0")
        ) {
          closeRecu();
        } else if (
          !document
            .getElementById("alert-popup")
            .classList.contains("opacity-0")
        ) {
          closeAlert();
        }
      });

      // Fermer avec la touche Échap
      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
          if (
            !document
              .getElementById("achat-popup")
              .classList.contains("opacity-0")
          ) {
            closeAchatPopup();
          } else if (
            !document
              .getElementById("recu-popup")
              .classList.contains("opacity-0")
          ) {
            closeRecu();
          } else if (
            !document
              .getElementById("alert-popup")
              .classList.contains("opacity-0")
          ) {
            closeAlert();
          }
        }
      });

      document
        .getElementById("achat-form")
        .addEventListener("submit", async function (e) {
          e.preventDefault();

          const compteur = document.getElementById("compteur").value.trim();
          const montant = parseFloat(document.getElementById("montant").value);

          // Validation côté client
          if (!compteur) {
            showAlert(
              "Veuillez saisir un numéro de compteur valide.",
              "error",
              "Champ requis"
            );
            return;
          }

          if (!montant || montant <= 0) {
            showAlert(
              "Veuillez saisir un montant valide.",
              "error",
              "Montant invalide"
            );
            return;
          }

          const submitBtn = this.querySelector('button[type="submit"]');
          const originalText = submitBtn.textContent;
          submitBtn.textContent = "Traitement en cours...";
          submitBtn.disabled = true;

          try {
            // Simulation d'un appel API réel
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
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
          }
        });
    </script>
  </body>
</html>
