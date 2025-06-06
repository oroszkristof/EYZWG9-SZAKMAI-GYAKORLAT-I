Szolgaltatas_tipusok


INSERT INTO szolgaltatas_tipusok (nev, leiras) VALUES
  ('Fogászat',       'Fogászati kezelések és vizsgálatok'),
  ('Szépségápolás',  'Arckezelések, manikűr/pedikűr szolgáltatások'),
  ('Fitness',        'Személyi edzés és csoportos alakformáló órák'),
  ('Fodrászat',      'Női és férfi hajvágás, hajfestés, styling szolgáltatások'),
  ('Elektronika',    'Mobiltelefon- és számítógép-javítás, szoftveres beállítások'),
  ('Egészségügy',   'Kórházi kezelések.');
  ('Autós', 'Autójavítási és karbantartási szolgáltatások');

Szolgaltatok

INSERT INTO szolgaltatok (szolgaltatas_tipusok_id, nev, leiras, aktiv) VALUES
  (1, 'SmileDent Rendelő',    'Teljeskörű fogászati ellátás Budapesten',                   TRUE),
  (1, 'EuroFogász Klinika',   'Modern implantológia és esztétikai fogászat',               TRUE),
  (1, 'DentalArt Kft.',       'Gyermekfogászat és fogszabályozás profi csapattal',         TRUE),
  (1, 'CityFogászat Centrum', 'Fogkő-eltávolítás, fogfehérítés gyors időpontfoglalással',  TRUE),
  (2, 'Beauty&You Szalon',    'Arckezelés és professzionális smink készítés',              TRUE),
  (2, 'Nails&Hairs Stúdió',   'Manikűr, pedikűr és balayage hajfestés egy helyen',         TRUE),
  (2, 'Elegance Spa',         'Arc- és testkezelések luxus-környezetben',                   TRUE),
  (2, 'PerfectBeauty Kft.',    'Kozmetikai tanácsadás, sminkoktatás, SPA csomagok',          TRUE),
  (3, 'ProGym Edzőterem',     'Személyi edzés, crossfit és súlyzós edzés profi edzőkkel',   TRUE),
  (3, 'FitLife Csoportos',    'Csoportos alakformáló órák: zumba, pilates, jóga',           TRUE),
  (3, 'IronClub Terem',       'Erőemelő szekció, funkcionális tréning és erőnléti programok', TRUE),
  (3, 'Cardio4U Fitness',     'Kardiógépek, aerob és spinning órák, táplálkozási tanácsadás', TRUE),
  (4, 'HairStyle Műhely',     'Férfi- és női hajvágás, profi vágók és fodrászok',            TRUE),
  (4, 'ColorMaster Stúdió',   'Különleges hajfestés, balayage és tonális festések',         TRUE),
  (4, 'TrendHair Salon',      'Legújabb trendek szerinti férfi- és női styling',             TRUE),
  (5, 'MobilMester Szerviz',  'Gyorstelefon-javítás, kijelzőcsere, akkumulátor csere',       TRUE),
  (5, 'PCPlus Számítástechnika', 'Laptop és asztali gép javítás, szoftveres telepítések',    TRUE),
  (5, 'GépDoktor Kft.',       'Garanciális és garancián túli javítások, szoftverlendítés',   TRUE),
  (6, 'Orvosi Centrum',       'Belgyógyászati és kardiológiai szakrendelések',              TRUE),
  (6, 'Sürgősségi Klinikák',  'Non-stop ügyelet és sürgősségi ellátás',                      TRUE);
 (8, 'Gyorsszerviz Expressz',       'Hibafelismerés és gyorsjavítás városközpontban',            1),
  (8, 'Olajszerviz Profi',            'Motorolaj csere és szűrőcsere a legjobb ár-érték arányban',  1),
  (8, 'Autómosó & Gumis',             'Teljes külső-belső autómosás, kerék- és gumiellenőrzés',     1),
  (8, 'Karosszéria Mester',           'Karosszéria- és fényezési munkák, horpadásjavítás',         1);
