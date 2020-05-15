DROP TABLE seccion_categoria_p;

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

