ALTER TABLE alumno_d ADD COLUMN c_ubigeo CHAR(6) AFTER c_direccion;
ALTER TABLE alumno_d ADD COLUMN c_ubigeo_representante1 CHAR(6) AFTER c_vinculo_representante1;
ALTER TABLE alumno_d ADD COLUMN c_ubigeo_representante2 CHAR(6) AFTER c_vinculo_representante2;

CREATE TABLE ubigeo_m(
  id_ubigeo CHAR(6),
  c_departamento CHAR(2) NOT NULL,
  c_provincia CHAR(2) NOT NULL,
  c_distrito CHAR(2) NOT NULL,
  c_nombre VARCHAR(191) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  c_root VARCHAR(191),
  secuencia INT,
  PRIMARY KEY(id_ubigeo)
);
