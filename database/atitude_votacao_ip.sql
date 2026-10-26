-- Executar uma vez. IPs de votos anteriores são desconhecidos e ficam NULL.
-- O IP não é UNIQUE: cada envio possui uma linha por projeto selecionado.
ALTER TABLE web_site.tbl_atitude_votacao
    ADD COLUMN ip_votante VARCHAR(45) CHARACTER SET ascii COLLATE ascii_bin NULL AFTER email,
    ADD KEY voto_ip (ip_votante);
