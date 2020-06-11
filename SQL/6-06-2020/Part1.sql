ALTER TABLE preferencia_d ADD COLUMN b_datos_adicionales_calculo TINYINT(1) DEFAULT 0 AFTER id_usuario;
ALTER TABLE preferencia_d ADD COLUMN c_modo_emision CHAR(3) DEFAULT 'DET' COMMENT 'DET = detallado,DIR = directo' AFTER b_datos_adicionales_calculo;
