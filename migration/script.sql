-- Création de la table 'profil' (rôles des utilisateurs)
CREATE TABLE IF NOT EXISTS profil (
    id SERIAL PRIMARY KEY,
    role VARCHAR(50) UNIQUE NOT NULL
);

-- Création de la table 'utilisateur'
CREATE TABLE IF NOT EXISTS utilisateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    numero_cni VARCHAR(20) UNIQUE NOT NULL,
    photo_recto_cni VARCHAR(255),
    photo_verso_cni VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    profil_id INTEGER NOT NULL,
    FOREIGN KEY (profil_id) REFERENCES profil(id)
);

-- Création de la table 'compte'
CREATE TABLE IF NOT EXISTS compte (
    id SERIAL PRIMARY KEY,
    telephone VARCHAR(12) UNIQUE NOT NULL,
    solde NUMERIC(15, 2) DEFAULT 0.00 NOT NULL,
    type VARCHAR(50) NOT NULL, -- Ex: 'Principal', 'Secondaire'
    client_id INTEGER NOT NULL,
    FOREIGN KEY (client_id) REFERENCES utilisateur(id)
);

-- Création de la table 'transaction'
CREATE TABLE IF NOT EXISTS transaction (
    id SERIAL PRIMARY KEY,
    montant NUMERIC(15, 2) NOT NULL,
    type VARCHAR(50) NOT NULL, -- Ex: 'Depot', 'Retrait', 'Paiement'
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    compte_id INTEGER NOT NULL,
    FOREIGN KEY (compte_id) REFERENCES compte(id)
);

-- Ajout des index pour optimiser les requêtes (comme discuté précédemment)
CREATE INDEX IF NOT EXISTS idx_compte_client_id ON compte (client_id);
CREATE INDEX IF NOT EXISTS idx_compte_telephone ON compte (telephone);
CREATE INDEX IF NOT EXISTS idx_transaction_compte_id ON transaction (compte_id);
CREATE INDEX IF NOT EXISTS idx_utilisateur_numero_cni ON utilisateur (numero_cni);
CREATE INDEX IF NOT EXISTS idx_transaction_date ON transaction (date DESC);
