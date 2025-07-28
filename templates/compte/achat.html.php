<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Achat Woyofal</title>
  <style>
    #achat-popup, #recu-popup, #overlay {
      display: none;
    }
    #achat-popup, #recu-popup {
      position: fixed;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      border: 2px solid #333;
      padding: 30px;
      z-index: 1001;
      min-width: 300px;
    }
    #overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
    }
    .btn { padding: 10px 20px; margin: 5px; }
    .btn-primary { background: #007bff; color: #fff; border: none; }
    .error { color: red; margin: 10px 0; }
  </style>
</head>
<body>
  <h2>Achat de crédit Woyofal</h2>
  <button class="btn btn-primary" onclick="openAchatPopup()">Paiement Woyofal</button>

  <!-- Popup Formulaire Achat -->
  <div id="achat-popup">
    <h3>Formulaire d'achat Woyofal</h3>
    <form id="achat-form">
      <label for="compteur">Numéro de compteur :</label>
      <input type="text" id="compteur" name="compteur" required><br><br>
      <label for="montant">Montant :</label>
      <input type="number" id="montant" name="montant" required><br><br>
      <button type="submit" class="btn btn-primary">Valider le paiement</button>
      <button type="button" class="btn" onclick="closeAchatPopup()">Annuler</button>
    </form>
  </div>

  <!-- Popup reçu -->
  <div id="recu-popup">
    <h3>Reçu d'achat</h3>
    <p><strong>Nom et Prénom :</strong> <span id="client"></span></p>
    <p><strong>Numéro de compteur :</strong> <span id="compteur_recu"></span></p>
    <p><strong>Référence :</strong> <span id="reference"></span></p>
    <p><strong>Code de recharge :</strong> <span id="code"></span></p>
    <p><strong>Nombre KWT :</strong> <span id="nbreKwt"></span></p>
    <p><strong>Date :</strong> <span id="date"></span></p>
    <p><strong>Tranche :</strong> <span id="tranche"></span></p>
    <p><strong>Prix unitaire :</strong> <span id="prix"></span></p>
    <button onclick="printRecu()" class="btn btn-primary">Imprimer</button>
    <button onclick="closeRecu()" class="btn">Fermer</button>
  </div>
  <div id="overlay"></div>

  <script>
    function openAchatPopup() {
      document.getElementById('achat-popup').style.display = 'block';
      document.getElementById('overlay').style.display = 'block';
    }
    function closeAchatPopup() {
      document.getElementById('achat-popup').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
    }
    function closeRecu() {
      document.getElementById('recu-popup').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
    }
    function printRecu() {
      const recuContent = document.getElementById('recu-popup').innerHTML;
      const printWindow = window.open('', '', 'width=600,height=600');
      printWindow.document.write('<html><head><title>Reçu d\'achat</title></head><body>' + recuContent + '</body></html>');
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    }

    document.getElementById('achat-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      const compteur = document.getElementById('compteur').value;
      const montant = document.getElementById('montant').value;

      // Afficher un indicateur de chargement
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Traitement en cours...';
      submitBtn.disabled = true;

      try {
        const response = await fetch('<?= BASE_URL ?>achat/process', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ compteur, montant })
        });

        const result = await response.json();
        
        if (result.statut === 'success' && result.data) {
          // Remplir le reçu avec les données
          document.getElementById('client').textContent = result.data.client?.nom + ' ' + result.data.client?.prenom || 'N/A';
          document.getElementById('compteur_recu').textContent = result.data.compteur?.numero || compteur;
          document.getElementById('reference').textContent = result.data.reference || 'N/A';
          document.getElementById('code').textContent = result.data.codeRecharge || 'N/A';
          document.getElementById('nbreKwt').textContent = result.data.nbreKwt + ' KWT' || 'N/A';
          document.getElementById('date').textContent = result.data.date || 'N/A';
          document.getElementById('tranche').textContent = result.data.tranche?.nom || 'N/A';
          document.getElementById('prix').textContent = result.data.tranche?.prixParKwh + ' FCFA/KWT' || 'N/A';
          
          // Afficher le reçu
          document.getElementById('achat-popup').style.display = 'none';
          document.getElementById('recu-popup').style.display = 'block';
          document.getElementById('overlay').style.display = 'block';
        } else {
          alert(result.error || result.message || 'Erreur lors de l\'achat');
        }
      } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur de connexion. Veuillez réessayer.');
      } finally {
        // Restaurer le bouton
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  </script>
</body>
</html>