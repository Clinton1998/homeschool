CREATE TABLE comunicado_d(
    id_comunicado INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    c_titulo VARCHAR(100) NOT NULL,
    c_descripcion TEXT,
    c_url_imagen TEXT,
    c_destino CHAR(4) NOT NULL DEFAULT 'TODO',
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_comunicado)
);

ALTER TABLE comunicado_d ADD CONSTRAINT comunicado_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE comunicado_d ADD CONSTRAINT comunicado_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE comunicado_d ADD CONSTRAINT comunicado_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);