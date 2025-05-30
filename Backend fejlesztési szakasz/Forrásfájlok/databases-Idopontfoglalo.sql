DATABASES - Idopontfoglalo - MariaDB

Felhasznalok

CREATE TABLE felhasznalok (
  id INT(50) PRIMARY KEY,
  nev CHAR(100) NOT NULL,
  szerepkor CHAR(50) NOT NULL,
  email CHAR(100) NOT NULL UNIQUE,
  jelszo CHAR(255) NOT NULL,
  reg_datum DATETIME DEFAULT CURRENT_TIMESTAMP
);

Szolgaltatok

CREATE TABLE szolgaltatok (
  id INT(50) PRIMARY KEY,
  szolgaltatas_tipusok_id INT(50) NOT NULL,
  nev CHAR(100) NOT NULL,
  leiras CHAR(256),
  aktiv BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (szolgaltatas_tipusok_id) REFERENCES szolgaltatas_tipusok(id)
);


Idopontok

CREATE TABLE idopontok (
  id INT(50) PRIMARY KEY,
  szolgaltatok_id INT(256) NOT NULL,
  datum DATE NOT NULL,
  ido TIME NOT NULL,
  foglalhato BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (szolgaltatok_id) REFERENCES szolgaltatok(id)
);


Foglalasok

CREATE TABLE foglalasok (
  id INT(50) PRIMARY KEY,
  felhasznalok_id INT(10) NOT NULL,
  idopontok_id INT(10) NOT NULL UNIQUE,
  foglalasi_ido DATETIME DEFAULT CURRENT_TIMESTAMP,
  allapot CHAR(50) NOT NULL,
  megjegyzes CHAR(50),
  FOREIGN KEY (felhasznalok_id) REFERENCES felhasznalok(id),
  FOREIGN KEY (idopontok_id) REFERENCES idopontok(id)
);

Szolgaltatas_tipusok

CREATE TABLE szolgaltatas_tipusok (
  id INT(50) PRIMARY KEY,
  nev CHAR(100) NOT NULL,
  leiras CHAR(100)
);


