
--username = innovaschool
--password=innova2019//..scl

ALTER TABLE users ADD COLUMN id_docente INT AFTER password;
ALTER TABLE users ADD COLUMN id_alumno INT AFTER id_docente;
ALTER TABLE users ADD COLUMN b_root TINYINT(1) AFTER id_alumno;
ALTER TABLE users ADD COLUMN estado TINYINT(1) AFTER b_root;
ALTER TABLE users ADD COLUMN creador INT AFTER estado;
ALTER TABLE users ADD COLUMN modificador INT AFTER created_at;


CREATE TABLE colegio_m(
    id_colegio INT AUTO_INCREMENT,
    c_razon_social TEXT NOT NULL,
    c_ruc CHAR(11) NOT NULL,
    c_correo VARCHAR(60) NOT NULL,
    c_telefono VARCHAR(20) NOT NULL,
    id_superadministrador INT NOT NULL,
    c_dni_representante CHAR(8) NOT NULL,
    c_representante_legal VARCHAR(255) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_colegio)
);
ALTER TABLE colegio_m ADD CONSTRAINT FK_colegio_m_users_id_superadministrador FOREIGN KEY (id_superadministrador) REFERENCES users (id);
ALTER TABLE colegio_m ADD CONSTRAINT FK_colegio_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE colegio_m ADD CONSTRAINT FK_colegio_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
