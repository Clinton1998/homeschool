CREATE TABLE categoria_d(
    id_categoria INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    c_nombre VARCHAR(100) NOT NULL,
    c_nivel_academico VARchar(100) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_categoria)
);

ALTER TABLE categoria_d ADD CONSTRAINT categoria_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE categoria_d ADD CONSTRAINT categoria_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE categoria_d ADD CONSTRAINT categoria_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


INSERT INTO categoria_d(id_colegio,c_nombre,c_nivel_academico,creador) VALUES
(1,'Matemática','PRIMARIA',11),
(1,'Química','PRIMARIA',11),
(1,'Física','PRIMARIA',11),
(1,'Informatica','SECUNDARIA',11),
(1,'Botánica','SECUNDARIA',11),
(1,'Biología','PRIMARIA',11),
(1,'Arte','SECUNDARIA',11),
(1,'Religion','PRIMARIA',11),
(1,'Tecnologia','SECUNDARIA',11),
(1,'Informatica','PRIMARIA',11),
(1,'Dibujo','PRIMARIA',11),
(1,'Comunicacion','PRIMARIA',11);

CREATE TABLE seccion_categoria_p(
    id_seccion_categoria INT AUTO_INCREMENT,
    id_seccion INT NOT NULL,
    id_categoria INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_seccion_categoria)
);

ALTER TABLE seccion_categoria_p ADD CONSTRAINT seccion_categoria_p_seccion_d_id_seccion FOREIGN KEY (id_seccion) REFERENCES seccion_d (id_seccion);
ALTER TABLE seccion_categoria_p ADD CONSTRAINT seccion_categoria_p_categoria_d_id_categoria FOREIGN KEY (id_categoria) REFERENCES categoria_d (id_categoria);
ALTER TABLE seccion_categoria_p ADD CONSTRAINT seccion_categoria_p_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE seccion_categoria_p ADD CONSTRAINT seccion_categoria_p_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

INSERT INTO seccion_categoria_p(id_seccion,id_categoria,creador) VALUES
(1,1,11),
(1,2,11),
(1,3,11),
(1,4,11),
(2,5,11),
(2,6,11),
(2,7,11),
(2,8,11),
(2,9,11);