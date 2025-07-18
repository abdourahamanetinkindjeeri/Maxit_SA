CREATE DATABASE maxitsa;

\c maxitsa;

CREATE TYPE TypeTransaction AS ENUM ('RETRAIT', 'DEPOT', 'PAIEMENT');


CREATE TABLE profile (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE utilisateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL, -- Email
    password VARCHAR(255) NOT NULL,
    cni VARCHAR(13) UNIQUE NOT NULL,
    cni_recto VARCHAR(255) NOT NULL,
    cni_verso VARCHAR(255) NOT NULL,
    profile_id INT,
    CONSTRAINT fk_profile FOREIGN KEY (profile_id) REFERENCES profile(id)
);


CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    client_id INT NOT NULL,
    montant NUMERIC(15, 2) NOT NULL,
    telephone VARCHAR(14) UNIQUE NOT NULL,
    CONSTRAINT fk_client FOREIGN KEY (client_id) REFERENCES utilisateur(id)
);


CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    utilisateur_id INT,
    compte_id INT NOT NULL,
    montant NUMERIC(15, 2) NOT NULL,
    type_transaction TypeTransaction NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
    CONSTRAINT fk_compte FOREIGN KEY (compte_id) REFERENCES compte(id)
);