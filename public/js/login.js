document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const spinner = document.getElementById('spinner');

    function toggleSpinner(show) {
        spinner.classList.toggle('hidden', !show);
        if (show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            toggleSpinner(true);
            
            const formData = new FormData(form);
            const response = await fetch('/', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            
            if (response.redirected || text.includes('dashboard')) {
                window.location.href = '/client/dashboard';
            } else {
                document.documentElement.innerHTML = text;
            }
        } catch (error) {
            console.error('Erreur:', error);
        } finally {
            toggleSpinner(false);
        }
    });
});