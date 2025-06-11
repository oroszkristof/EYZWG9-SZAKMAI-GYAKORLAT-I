INSERT INTO idopontok (szolgaltatok_id, datum, ido, foglalhato)
SELECT 
  s.id, 
  '2025-06-10' AS datum,
  t.ido,
  1 AS foglalhato
FROM szolgaltatok AS s
CROSS JOIN (
  SELECT '09:00:00' AS ido UNION ALL
  SELECT '10:00:00'        UNION ALL
  SELECT '11:00:00'        UNION ALL
  SELECT '12:00:00'        UNION ALL
  SELECT '13:00:00'
) AS t
ORDER BY s.id, t.ido;
