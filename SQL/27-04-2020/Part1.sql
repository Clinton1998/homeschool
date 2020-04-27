CREATE TABLE docente_categoria_p(
    id_docente_categoria INT AUTO_INCREMENT,
    id_docente INT NOT NULL,
    id_categoria INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_docente_categoria)
);

ALTER TABLE docente_categoria_p ADD CONSTRAINT docente_categoria_p_docente_d_id_docente FOREIGN KEY (id_docente) REFERENCES docente_d (id_docente);
ALTER TABLE docente_categoria_p ADD CONSTRAINT docente_categoria_p_categoria_d_id_categoria FOREIGN KEY (id_categoria) REFERENCES categoria_d (id_categoria);

ALTER TABLE docente_categoria_p ADD CONSTRAINT docente_categoria_p_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE docente_categoria_p ADD CONSTRAINT docente_categoria_p_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);