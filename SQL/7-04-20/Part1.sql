CREATE TABLE docente_d(
    id_docente INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    c_dni CHAR(8) NOT NULL,
    c_nombre VARCHAR(255) NOT NULL,
    c_nacionalidad VARCHAR(60) NOT NULL,
    c_sexo CHAR(1) NOT NULL,
    t_fecha_nacimiento DATE NOT NULL,
    c_correo VARCHAR(255) NOT NULL,
    c_telefono VARCHAR(20),
    c_direccion TEXT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_docente)
);

ALTER TABLE docente_d ADD CONSTRAINT docente_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE docente_d ADD CONSTRAINT docente_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE docente_d ADD CONSTRAINT docente_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


CREATE TABLE grado_m(
    id_grado INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    c_nombre VARCHAR(60) NOT NULL,
    c_nivel_academico VARCHAR(60) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_grado)
);

ALTER TABLE grado_m ADD CONSTRAINT grado_m_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE grado_m ADD CONSTRAINT grado_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE grado_m ADD CONSTRAINT grado_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

CREATE TABLE seccion_d(
    id_seccion INT AUTO_INCREMENT,
    id_grado INT NOT NULL,
    c_nombre VARCHAR(60) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_seccion)
);

ALTER TABLE seccion_d ADD CONSTRAINT seccion_d_grado_m_id_grado FOREIGN KEY (id_grado) REFERENCES grado_m (id_grado);
ALTER TABLE seccion_d ADD CONSTRAINT seccion_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE seccion_d ADD CONSTRAINT seccion_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


CREATE TABLE alumno_d(
    id_alumno INT AUTO_INCREMENT,
    id_seccion INT NOT NULL,
    c_dni CHAR(8) NOT NULL,
    c_nombre VARCHAR(255) NOT NULL,
    c_nacionalidad VARCHAR(60) NOT NULL,
    c_sexo CHAR(1) NOT NULL,
    t_fecha_nacimiento DATE NOT NULL,
    c_direccion TEXT NOT NULL,
    c_informacion_adicional TEXT,
    c_dni_representante1 CHAR(8),
    c_nombre_representante1 VARCHAR(255),
    c_nacionalidad_representante1 VARCHAR(60),
    c_sexo_representante1 CHAR(1),
    c_telefono_representante1 VARCHAR(20),
    c_correo_representante1 VARCHAR(200),
    c_direccion_representante1 TEXT,
    c_vinculo_representante1 VARCHAR(20),
    c_dni_representante2 CHAR(8),
    c_nombre_representante2 VARCHAR(255),
    c_nacionalidad_representante2 VARCHAR(60),
    c_sexo_representante2 CHAR(1),
    c_telefono_representante2 VARCHAR(20),
    c_correo_representante2 VARCHAR(200),
    c_direccion_representante2 TEXT,
    c_vinculo_representante2 VARCHAR(20),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_alumno)
);


ALTER TABLE alumno_d ADD CONSTRAINT alumno_d_seccion_d_id_seccion FOREIGN KEY (id_seccion) REFERENCES seccion_d (id_seccion);
ALTER TABLE alumno_d ADD CONSTRAINT alumno_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE alumno_d ADD CONSTRAINT alumno_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--ingresando secciones a los grados
INSERT INTO seccion_d(id_grado,c_nombre,creador) VALUES
(1,'A',11),
(1,'B',11),
(1,'C',11);