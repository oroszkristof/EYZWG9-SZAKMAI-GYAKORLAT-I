-- Szolgáltatás típusa
INSERT INTO szolgaltatas_tipusok (id, nev, leiras) VALUES
(1, 'Fogászat', 'Fogászati kezelések és vizsgálatok');

-- Szolgáltatók
INSERT INTO szolgaltatok (id, szolgaltatas_tipusok_id, nev, leiras, aktiv) VALUES
(1, 1, 'SmileDent', 'Budapesti rendelő', TRUE);

-- Felhasználók
INSERT INTO felhasznalok (id, nev, szerepkor, email, jelszo) VALUES
(1, 'Kiss Gábor', 'felhasznalo', 'gabor@example.com', 'pass1'),
(2, 'Nagy Anna', 'admin', 'anna@example.com', 'admin123');
