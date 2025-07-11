INSERT INTO profile (libelle) VALUES
('Client'),
('Commercial'),


-- Insertion des utilisateurs (avec emails)
INSERT INTO utilisateur (nom, prenom, login, password, cni, cni_recto, cni_verso, profile_id) VALUES
('Admin', 'Root', 'admin@gmail.com', 'admin', '2020999999999', 'admin_recto.png', 'admin_verso.png', 1),
('Sow', 'Aminata', 'aminata.sow@gmail.com', 'pass123', '2020000000001', 'aminata_recto.png', 'aminata_verso.png', 1),
('Diop', 'Cheikh', 'cheikh.diop@gmail.com', 'pass123', '2020000000002', 'cheikh_recto.png', 'cheikh_verso.png', 2),
('Diallo', 'Moussa', 'moussa.diallo@gmail.com', 'pass123', '2020123456789', 'moussa_recto.png', 'moussa_verso.png', 3),
('Traoré', 'Fatoumata', 'fatou.tr@gmail.com', 'pass123', '2020987654321', 'fatou_recto.png', 'fatou_verso.png', 3);

-- Insertion des comptes
INSERT INTO compte (client_id, montant, telephones) VALUES
(4, 250000.00, ARRAY['+221770000001', '+221770000002']),
(5, 150000.00, ARRAY['+221771234567']);

-- Insertion des transactions
INSERT INTO transaction (utilisateur_id, compte_id, montant, type_transaction) VALUES
(3, 1, 50000.00, 'RETRAIT'),
(3, 2, 100000.00, 'DEPOT'),
(3, 1, 25000.00, 'PAIEMENT');
