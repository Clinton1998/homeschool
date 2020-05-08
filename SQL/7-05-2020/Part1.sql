CREATE TABLE modulo_d(
    id_modulo INT AUTO_INCREMENT,
    id_seccion_categoria INT NOT NULL,
    c_nombre VARCHAR(100) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_modulo)
);

ALTER TABLE modulo_d ADD CONSTRAINT FK_modulo_d_seccion_categoria_p_id_seccion_categoria FOREIGN KEY (id_seccion_categoria) REFERENCES seccion_categoria_p (id_seccion_categoria);
ALTER TABLE modulo_d ADD CONSTRAINT FK_modulo_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE modulo_d ADD CONSTRAINT FK_modulo_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


CREATE TABLE archivo_d(
    id_archivo INT AUTO_INCREMENT,
    id_modulo INT NOT NULL,
    c_nombre VARCHAR(100) NOT NULL,
    c_url TEXT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_archivo)
);

ALTER TABLE archivo_d ADD CONSTRAINT FK_archivo_d_modulo_d_id_modulo FOREIGN KEY (id_modulo) REFERENCES modulo_d (id_modulo);
ALTER TABLE archivo_d ADD CONSTRAINT FK_archivo_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE archivo_d ADD CONSTRAINT FK_archivo_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);