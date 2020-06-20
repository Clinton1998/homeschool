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
