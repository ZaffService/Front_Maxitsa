<!-- templates/client/achat-woyafal.php -->
<a href="/client/dashboard" style="color:#10b981;text-decoration:none;"><i class="bi bi-arrow-left"></i> Retour au dashboard</a>
<h2 style="color:#10b981;">Achat Woyofal</h2>
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
    <h3>Reçu Woyofal</h3>
    <pre><?= print_r($recu, true) ?></pre>
<?php endif; ?>