CREATE TABLE configuracion_m(
  id_configuracion INT AUTO_INCREMENT,
  c_api_dni TEXT NOT NULL,
  c_api_ruc TEXT NOT NULL,
  c_api_concord TEXT NOT NULL,
  c_message_corte_prueba VARCHAR(191),
  PRIMARY  KEY(id_configuracion)
);

INSERT INTO configuracion_m(c_api_dni,c_api_ruc,c_api_concord) VALUES
('http://bytesoluciones.com/apidnix/apidni.php?dni=','http://144.217.215.6/sunat/libre.php?ruc=','https://pruebacobrador.innovaqp.com/api');

ALTER TABLE colegio_m DROP COLUMN t_corte_normal;

ALTER TABLE colegio_m ADD COLUMN c_token TEXT AFTER t_corte_prueba;
ALTER TABLE colegio_m ADD COLUMN c_clave TEXT AFTER c_token;
