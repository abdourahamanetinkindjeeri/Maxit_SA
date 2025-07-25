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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Maxit Sénégal</title>
</head>

<body class="bg-gradient-to-br from-maxitOrange/80 via-maxitGray to-maxitOrangeDark/70 min-h-screen flex flex-col items-center justify-center">
    <!-- Messages d'erreur et de succès -->
    <?php include 'partials/_messages.php'; ?>

    <!-- Formulaire principal -->
    <?php include 'partials/_form.php'; ?>

    <!-- Modal -->
    <?php include 'partials/_modal.php'; ?>

    <script>
        // Fonction pour configurer les champs CNI recto et verso
        function setupCNIImages(rectoUrl, versoUrl) {
            if (rectoUrl) {
                makeFieldReadonly('cni_recto_url', rectoUrl);
            }
            if (versoUrl) {
                makeFieldReadonly('cni_verso_url', versoUrl);
            }
        }

        // Fonction pour réinitialiser les champs CNI recto et verso
        function resetCNIImages() {
            resetField('cni_recto_url');
            resetField('cni_verso_url');
        }

        function showCustomPopup(title, message, type = 'info', showCancel = false) {
            return new Promise((resolve) => {
                const modal = document.getElementById('customModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                const modalIcon = document.getElementById('modalIcon');
                const modalConfirm = document.getElementById('modalConfirm');
                const modalCancel = document.getElementById('modalCancel');

                modalTitle.textContent = title;
                modalMessage.textContent = message;

                if (type === 'warning') {
                    modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.134 16.5c-.77.833.192 2.5 1.732 2.5z"></path>';
                } else if (type === 'error') {
                    modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                } else {
                    modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                }

                if (showCancel) {
                    modalCancel.classList.remove('hidden');
                } else {
                    modalCancel.classList.add('hidden');
                }

                modal.classList.remove('hidden');

                const confirmHandler = () => {
                    modal.classList.add('hidden');
                    modalConfirm.removeEventListener('click', confirmHandler);
                    modalCancel.removeEventListener('click', cancelHandler);
                    resolve(true);
                };

                const cancelHandler = () => {
                    modal.classList.add('hidden');
                    modalConfirm.removeEventListener('click', confirmHandler);
                    modalCancel.removeEventListener('click', cancelHandler);
                    resolve(false);
                };

                modalConfirm.addEventListener('click', confirmHandler);
                modalCancel.addEventListener('click', cancelHandler);

                const escapeHandler = (e) => {
                    if (e.key === 'Escape') {
                        modal.classList.add('hidden');
                        document.removeEventListener('keydown', escapeHandler);
                        modalConfirm.removeEventListener('click', confirmHandler);
                        modalCancel.removeEventListener('click', cancelHandler);
                        resolve(false);
                    }
                };
                document.addEventListener('keydown', escapeHandler);
            });
        }

        // Fonction pour rendre un champ readonly avec style
        function makeFieldReadonly(fieldId, value) {
            const field = document.getElementById(fieldId);
            if (field && value) {
                field.value = value;
                field.readOnly = true;
                field.classList.add('bg-gray-100', 'cursor-not-allowed');
                field.classList.remove('border-gray-200', 'focus:ring-maxitOrange/60', 'focus:border-maxitOrange');
                field.classList.add('border-gray-300');
            }
        }

        // Fonction pour réinitialiser un champ
        function resetField(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = '';
                field.readOnly = false;
                field.classList.remove('bg-gray-100', 'cursor-not-allowed', 'border-gray-300');
                field.classList.add('border-gray-200', 'focus:ring-maxitOrange/60', 'focus:border-maxitOrange');
            }
        }

        document.getElementById('cni').addEventListener('input', async function () {
            const cni = this.value.trim();
            const cniAlert = document.getElementById('cniAlert');
            const cniLoading = document.getElementById('cniLoading');
            const cniSuccess = document.getElementById('cniSuccess');

            cniAlert.classList.add('hidden');
            cniLoading.classList.add('hidden');
            cniSuccess.classList.add('hidden');

            if (cni.length === 13) {
                cniLoading.classList.remove('hidden');

                try {
                    const response = await fetch(`https://appdaf-g15c.onrender.com/api/citoyen/${cni}`);
                    const citoyen = await response.json();

                    cniLoading.classList.add('hidden');

                    if (!citoyen || citoyen.code !== 200 || !citoyen.data) {
                        cniAlert.classList.remove('hidden');
                    } else {
                        cniSuccess.classList.remove('hidden');

                        const data = citoyen.data;
                        const prenomValue = data.prenom || '';
                        const nomValue = data.nom || '';
                        const emailValue = data.email || '';
                        const telephoneValue = data.telephone || data.phone || '';
                        const rectoUrl = data.url_carte_recto || '';
                        const versoUrl = data.url_carte_verso || '';

                        if (prenomValue) makeFieldReadonly('prenom', prenomValue);
                        if (nomValue) makeFieldReadonly('nom', nomValue);
                        if (emailValue) makeFieldReadonly('login', emailValue);
                        if (telephoneValue) makeFieldReadonly('telephone', telephoneValue);
                        if (rectoUrl) makeFieldReadonly('cni_recto_url', rectoUrl);
                        if (versoUrl) makeFieldReadonly('cni_verso_url', versoUrl);

                        makeFieldReadonly('cni', cni);

                        console.log("Structure de l'API:", citoyen);
                        console.log("Données extraites:", data);
                        console.log("Champs remplis:", {
                            prenom: prenomValue,
                            nom: nomValue,
                            email: emailValue,
                            telephone: telephoneValue,
                            carte_recto: rectoUrl,
                            carte_verso: versoUrl,
                            date_naissance: data.date,
                            lieu_naissance: data.lieu
                        });

                        await showCustomPopup(
                            'Informations récupérées',
                            `Citoyen: ${prenomValue} ${nomValue}\nNé(e) le: ${data.date || 'Non disponible'}\nLieu: ${data.lieu || 'Non disponible'}\nPhotos CNI: ${rectoUrl && versoUrl ? 'Recto et Verso récupérés' : rectoUrl ? 'Recto récupéré' : versoUrl ? 'Verso récupéré' : 'Non disponibles'}`,
                            'info'
                        );
                    }
                } catch (error) {
                    console.error("Erreur lors de la récupération :", error);
                    cniLoading.classList.add('hidden');
                    cniAlert.classList.remove('hidden');
                }
            } else if (cni.length === 0) {
                resetField('nom');
                resetField('prenom');
                resetField('login');
                resetField('telephone');
                resetField('cni');
                resetField('cni_recto_url');
                resetField('cni_verso_url');
            }
        });

        document.getElementById('cni').addEventListener('focus', async function() {
            if (this.readOnly) {
                const shouldReset = await showCustomPopup(
                    'Modifier le CNI',
                    'Voulez-vous modifier le numéro CNI ? Cela effacera toutes les informations pré-remplies.',
                    'warning',
                    true
                );

                if (shouldReset) {
                    resetField('nom');
                    resetField('prenom');
                    resetField('login');
                    resetField('telephone');
                    resetField('cni');
                    resetField('cni_recto_url');
                    resetField('cni_verso_url');

                    document.getElementById('cniAlert').classList.add('hidden');
                    document.getElementById('cniSuccess').classList.add('hidden');
                    document.getElementById('cniLoading').classList.add('hidden');

                    setTimeout(() => this.focus(), 100);
                }
            }
        });

        document.addEventListener('keydown', async function(e) {
            if (e.target.readOnly && e.target.id !== 'cni') {
                e.preventDefault();
                await showCustomPopup(
                    'Champ protégé',
                    'Ce champ a été pré-rempli automatiquement. Pour le modifier, vous devez d\'abord changer le numéro CNI.',
                    'info'
                );
            }
        });

        document.addEventListener('click', async function(e) {
            if (e.target.readOnly && e.target.id !== 'cni' && e.target.tagName === 'INPUT') {
                await showCustomPopup(
                    'Champ protégé',
                    'Ce champ a été pré-rempli automatiquement. Pour le modifier, cliquez sur le champ CNI.',
                    'info'
                );
            }
        });
    </script>
</body>
</html>