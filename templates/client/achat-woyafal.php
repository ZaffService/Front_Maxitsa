<!-- templates/client/achat-woyafal.php -->
<a href="/client/dashboard" style="color:#10b981;text-decoration:none;"><i class="bi bi-arrow-left"></i> Retour au dashboard</a>
<h2 style="color:#fff; background:#10b981; padding:16px; border-radius:12px; text-align:center; box-shadow:0 2px 8px #10b98144; margin-top:24px;">
    <i class="bi bi-lightning-charge"></i> Achat Woyofal
</h2>
<form method="POST" action="/client/achat-woyafal" style="max-width:400px;margin:auto;">
    <label>Numéro de compteur :</label>
    <input type="text" name="numero_compteur" required class="search-input" style="width:100%;margin-bottom:12px;">
    <label>Montant :</label>
    <input type="number" name="montant" required class="search-input" style="width:100%;margin-bottom:12px;">
    <button type="submit" style="background:#10b981;color:white;padding:10px 24px;border:none;border-radius:8px;">Acheter</button>
</form>
<?php if (!empty($message)): ?>
    <div style="color:green;margin-top:16px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div style="color:red;margin-top:16px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($recu)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html = `
                <div style="background:#fff;max-width:420px;margin:40px auto;padding:32px 24px;border-radius:16px;box-shadow:0 4px 24px #10b98144;text-align:left;position:relative;">
                    <h3 style="color:#10b981;font-size:1.5rem;margin-bottom:16px;">Reçu Woyofal</h3>
                    <div style="margin-bottom:8px;"><b>Client :</b> <?= htmlspecialchars($recu['client']) ?></div>
                    <div style="margin-bottom:8px;"><b>Compteur :</b> <?= htmlspecialchars($recu['compteur']) ?></div>
                    <div style="margin-bottom:8px;"><b>Référence :</b> <?= htmlspecialchars($recu['reference']) ?></div>
                    <div style="margin-bottom:8px;"><b>Code :</b> <span style="font-family:monospace;font-size:1.1em;"><?= htmlspecialchars($recu['code']) ?></span></div>
                    <div style="margin-bottom:8px;"><b>Date :</b> <?= htmlspecialchars($recu['date']) ?></div>
                    <div style="margin-bottom:8px;"><b>Tranche :</b> <?= htmlspecialchars($recu['tranche']) ?></div>
                    <div style="margin-bottom:8px;"><b>Prix unitaire :</b> <?= htmlspecialchars($recu['prix']) ?> FCFA</div>
                    <div style="margin-bottom:8px;"><b>Nombre de Kwh :</b> <?= htmlspecialchars($recu['nbreKwt']) ?></div>
                    <button onclick="document.getElementById('popup-recu').remove()" style="margin-top:18px;background:#10b981;color:#fff;padding:10px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer;">Fermer</button>
                </div>
            `;
            let popup = document.createElement('div');
            popup.id = 'popup-recu';
            popup.style.position = 'fixed';
            popup.style.top = 0;
            popup.style.left = 0;
            popup.style.width = '100vw';
            popup.style.height = '100vh';
            popup.style.background = 'rgba(0,0,0,0.25)';
            popup.style.zIndex = 9999;
            popup.innerHTML = html;
            document.body.appendChild(popup);
        });
    </script>
<?php endif; ?>