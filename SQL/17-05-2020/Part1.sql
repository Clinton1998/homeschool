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