document.addEventListener('DOMContentLoaded', function() {
    console.log('Script chargé et exécuté !');
    
  
    
    const cniInput = document.getElementById('numero_cni');
    const hiddenFields = document.getElementById('hiddenFields');
    const submitBtn = document.getElementById('submitBtn');
    const checkBtn = document.getElementById('checkCitizenBtn');
    const form = document.getElementById('registrationForm');
    const statusMessage = document.getElementById('statusMessage');

    // Modifier le HTML du spinner
    const spinner = `
        <div id="spinner" class="hidden fixed top-0 left-0 right-0 bg-white bg-opacity-80 flex items-center justify-center" style="height: 100vh; z-index: 1000;">
            <div class="text-center">
                <svg class="w-16 h-16 animate-spin text-gray-900/50 mx-auto" viewBox="0 0 64 64" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                        stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path
                        d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                        stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                    </path>
                </svg>
                <p class="mt-2 text-gray-600">Création du compte en cours...</p>
            </div>
        </div>`;

    // Insérer le spinner dans le body plutôt que dans le form
    document.body.insertAdjacentHTML('beforeend', spinner);
    const spinnerElement = document.getElementById('spinner');

    // Fonction pour montrer/cacher le spinner
    function toggleSpinner(show) {
        if (show) {
            document.body.style.overflow = 'hidden'; // Empêcher le scroll
        } else {
            document.body.style.overflow = ''; // Rétablir le scroll
        }
        spinnerElement.classList.toggle('hidden', !show);
        submitBtn.disabled = show;
    }

    // Fonction pour afficher les toasts
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastContent = toast.querySelector('div');
        
        // Définir la couleur de la bordure selon le type
        const borderColor = type === 'success' ? 'border-green-500' : 'border-red-500';
        const bgColor = type === 'success' ? 'bg-green-50' : 'bg-red-50';
        const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
        
        toastContent.className = `p-4 ${borderColor} ${bgColor} ${textColor} rounded-lg shadow-lg`;
        toastContent.textContent = message;
        
        // Afficher le toast
        toast.classList.remove('hidden');
        
        // Cacher le toast après 3 secondes
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    // Validation du numéro CNI
    function isValidCNI(cni) {
        return /^\d{13}$/.test(cni);
    }

    // Gestionnaire du bouton de vérification
    checkBtn.addEventListener('click', async function() {
        const cni = cniInput.value.trim();
        
        // Réinitialiser l'interface
        hiddenFields.classList.add('hidden');
        submitBtn.disabled = true;
        statusMessage.classList.add('hidden');
        
        // Vérifier le format CNI
        if (!isValidCNI(cni)) {
            showToast('Le numéro CNI doit contenir exactement 13 chiffres', 'error');
            return;
        }

        // Désactiver le bouton pendant la vérification
        checkBtn.disabled = true;
        checkBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Vérification...';

        try {
            const response = await fetch(`https://appdaf-0soa.onrender.com/citoyens/${cni}`);
            
            if (!response.ok) {
                // Afficher le code d'erreur HTTP
                console.log('Status:', response.status);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                // Si la réponse n'est pas du JSON
                throw new Error("La réponse n'est pas au format JSON!");
            }

            const data = await response.json();
            console.log('Données reçues:', data); // Pour debug

            // Vérifier la structure des données reçues
            if (data && data.data && data.data.nom && data.data.prenom) {
                // Obtenir les références des champs
                const nomInput = document.getElementById('nom');
                const prenomInput = document.getElementById('prenom');
                
                // Définir les valeurs (pas les placeholders)
                nomInput.value = data.data.nom;
                prenomInput.value = data.data.prenom;
                
                // S'assurer que les champs sont en lecture seule
                nomInput.readOnly = true;
                prenomInput.readOnly = true;
                
                // Afficher les champs cachés
                hiddenFields.classList.remove('hidden');
                submitBtn.disabled = false;
                
                showToast(' Citoyen trouvé');
                statusMessage.innerHTML = '<div class="text-green-600"><i class="bi bi-check-circle"></i> Citoyen vérifié avec succès</div>';
                statusMessage.classList.remove('hidden');
            } else {
                throw new Error('Format de données invalide');
            }
        } catch (error) {
            console.error('Erreur détaillée:', error);
            showToast(' Aucun citoyen trouvé avec ce numéro de CNI', 'error');
            statusMessage.innerHTML = '<div class="text-red-600"><i class="bi bi-x-circle"></i> Aucun citoyen trouvé</div>';
            statusMessage.classList.remove('hidden');
        } finally {
            // Réactiver le bouton
            checkBtn.disabled = false;
            checkBtn.innerHTML = '<i class="bi bi-search"></i> Vérifier le citoyen';
        }
    });

    // Gestionnaire de soumission du formulaire modifié
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            toggleSpinner(true);
            
            const formData = new FormData(form);
            const response = await fetch('/register', {
                method: 'POST',
                body: formData
            });

            const data = await response.text();
            
            // Vérifie si la réponse contient des erreurs
            if (data.includes('Ce numéro de téléphone est déjà utilisé') || 
                data.includes('Ce numéro CNI est déjà utilisé')) {
                showToast('Ce numéro de téléphone ou CNI est déjà utilisé', 'error');
                return;
            }

            if (response.ok) {
                showToast('Votre compte a été créé avec succès !', 'success');
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            } else {
                throw new Error('Erreur lors de la création du compte');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showToast(error.message, 'error');
        } finally {
            toggleSpinner(false);
        }
    });
});