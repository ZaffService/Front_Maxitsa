<div class="transactions-section">
            <div class="transactions-title">Transactions (<?= count($transactions) ?>)</div>
            <a href="/user/transactions" class="see-more">
                Voir plus <i class="bi bi-arrow-right"></i>
            </a>
          
            <a href="/client/depot-transfert" class="see-more" style="margin-left:16px; color:#10b981;">
                <i class="bi bi-arrow-right-circle"></i> Dépôt par transfert
            </a>

            <a href="/client/achat-woyafal" class="see-more" style="margin-left:16px; color:#10b981;">
                <i class="bi bi-lightning-charge"></i> Achat Woyofal
            </a>
        </div>

        <div class="transactions-list">
            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="bi <?= $transaction->getTypeIcon() ?>"></i>
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-title"><?= htmlspecialchars($transaction->getTypeLabel()) ?></div>
                            <div class="transaction-date">
                                <?= $transaction->getFormattedDate() ?>, 
                                <?= htmlspecialchars(number_format($transaction->getMontant(), 0, ',', ' ')) ?> FCFA
                            </div>
                        </div>
                        <div class="transaction-amount-container">
                            <div class="transaction-amount"><?= htmlspecialchars(number_format($transaction->getMontant(), 0, ',', ' ')) ?> FCFA</div>
                            <span class="transaction-badge <?= $transaction->getTypeBadgeClass() ?>">
                                <?= htmlspecialchars($transaction->getType()) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div class="transaction-title">Aucune transaction</div>
                        <div class="transaction-date">Vous n'avez pas encore effectué de transactions</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div style="margin-top: 16px;">
        <a href="/client/depot" 
           style="background:#10b981; color:#fff; padding:10px 22px; border-radius:8px; font-weight:600; font-size:1rem; text-decoration:none; float:right; margin-top:-40px; margin-right:24px; box-shadow:0 2px 8px #10b98144; transition:background 0.2s;"
           onmouseover="this.style.background='#059669';"
           onmouseout="this.style.background='#10b981';">
           <i class="bi bi-plus-circle"></i> Déposer
        </a>
    </div>

<style>
.transactions-section .see-more {
    color: #10b981 !important;
}
.transactions-section .see-more:hover {
    color: #059669 !important;
}
</style>
