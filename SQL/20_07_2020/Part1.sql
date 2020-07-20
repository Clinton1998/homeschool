/*alumno_d*/
/*ok*/

/*alumno_tarea_respuesta_p*/
/*ok*/

/*anuncio_d*/
--id_seccion_categoria no nullo

/*archivo_comunicado_d*/
CREATE TABLE archivo_comunicado_d(
    id_archivo INT AUTO_INCREMENT,
    id_comunicado INT NOT NULL,
    c_url_archivo TEXT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_archivo)
);

ALTER TABLE archivo_comunicado_d ADD CONSTRAINT archivo_comunicado_d_comunicado_d_id_comunicado FOREIGN KEY (id_comunicado) REFERENCES comunicado_d (id_comunicado);
ALTER TABLE archivo_comunicado_d ADD CONSTRAINT archivo_comunicado_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE archivo_comunicado_d ADD CONSTRAINT archivo_comunicado_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

/*archivo_d*/
/*ok*/

/*archivo_respuesta_d*/
CREATE TABLE archivo_respuesta_d(
  id_archivo INT AUTO_INCREMENT,
  id_respuesta INT NOT NULL,
  c_url_archivo TEXT NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  creador INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  modificador INT,
  updated_at TIMESTAMP,
  PRIMARY KEY(id_archivo)
);

ALTER TABLE archivo_respuesta_d ADD CONSTRAINT archivo_respuesta_d_respuesta_d_id_respuesta FOREIGN KEY (id_respuesta) REFERENCES respuesta_d (id_respuesta);
ALTER TABLE archivo_respuesta_d ADD CONSTRAINT archivo_respuesta_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE archivo_respuesta_d ADD CONSTRAINT archivo_respuesta_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

/*archivo_tarea_d*/
CREATE TABLE archivo_tarea_d(
  id_archivo INT AUTO_INCREMENT,
  id_tarea INT NOT NULL,
  c_url_archivo TEXT NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  creador INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  modificador INT,
  updated_at TIMESTAMP,
  PRIMARY KEY(id_archivo)
);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_tarea_d_id_tarea FOREIGN KEY (id_tarea) REFERENCES tarea_d (id_tarea);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

/*categoria_d*/
/*ok*/

/*colegio_m*/
--eliminar column t_corte_normal
ALTER TABLE colegio_m ADD COLUMN c_token TEXT AFTER t_corte_prueba;
ALTER TABLE colegio_m ADD COLUMN c_clave TEXT AFTER c_token;
ALTER TABLE colegio_m ADD COLUMN c_bloque_fact CHAR(5) AFTER c_clave;

/*comentario_d*/
/*ok*/

/*comprobante_d,detalle_comprobante_d,detalle_nota,documento_identidad_m
  moneda_m,motivo_nota_m,nota_d,preferencia_d,
  producto_servicio_d,serie_d
*/
--ejecutar SQL/20-05-2020

/*comunicado_d*/
/*ok*/

/*configuracion_m*/
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

/*conversations*/
/*ok*/

/*docente_categoria_p*/
--eliminar table y pasar los datos a la nueva relacion, si es posible hacerlo

/*docente_d*/
/*ok*/

/*docente_seccion_p*
/*ok*/

/*grado_m*/
-- ok

/*groups*/
-- ok

/*group_user*/
-- ok

/*herramienta_d*/
CREATE TABLE herramienta_d(
    id_herramienta INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    c_nombre VARCHAR(191) NOT NULL,
    c_logo_fisico TEXT,
    c_logo_link TEXT,
    c_link TEXT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_herramienta)
);

ALTER TABLE herramienta_d ADD CONSTRAINT herramienta_d_users_id_usuario FOREIGN KEY (id_usuario) REFERENCES users (id);
ALTER TABLE herramienta_d ADD CONSTRAINT herramienta_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE herramienta_d ADD CONSTRAINT herramienta_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

/*messages*/
-- ok
/*modulo_d*/
-- ok
/*notifications*/
-- ok

/*permitido_m*/
--eliminar tabla

/*respuesta_d*/
-- ok
/*seccion_categoria_docente_p*/

CREATE TABLE seccion_categoria_docente_p(
    id_seccion_categoria_docente INT AUTO_INCREMENT,
    id_seccion_categoria INT NOT NULL,
    id_docente INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_seccion_categoria_docente)
);

ALTER TABLE seccion_categoria_docente_p ADD CONSTRAINT seccion_categoria_docente_p_seccion_categoria_p_id_seccion_categoria FOREIGN KEY (id_seccion_categoria) REFERENCES seccion_categoria_p (id_seccion_categoria);
ALTER TABLE seccion_categoria_docente_p ADD CONSTRAINT seccion_categoria_docente_p_seccion_categoria_p_id_docente FOREIGN KEY (id_docente) REFERENCES docente_d (id_docente);

ALTER TABLE seccion_categoria_docente_p ADD CONSTRAINT seccion_categoria_docente_p_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE seccion_categoria_docente_p ADD CONSTRAINT seccion_categoria_docente_p_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

/*seccion_categoria_p*/
-- ok

/*seccion_d*/
-- ok

/*tarea_d*/
-- ok

--verificar la columna updated_at
