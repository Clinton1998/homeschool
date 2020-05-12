CREATE TABLE anuncio_d(
    id_anuncio INT AUTO_INCREMENT,
    id_seccion INT NOT NULL,
    id_seccion_categoria INT NOT NULL,
    c_titulo VARCHAR(191) NOT NULL,
    c_url_archivo TEXT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_anuncio)
);

ALTER TABLE anuncio_d ADD CONSTRAINT anuncio_d_seccion_d_id_seccion FOREIGN KEY (id_seccion) REFERENCES seccion_d (id_seccion);
ALTER TABLE anuncio_d ADD CONSTRAINT anuncio_d_seccion_categoria_p_id_seccion_categoria FOREIGN KEY (id_seccion_categoria) REFERENCES seccion_categoria_p (id_seccion_categoria);

ALTER TABLE anuncio_d ADD CONSTRAINT anuncio_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE anuncio_d ADD CONSTRAINT anuncio_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);