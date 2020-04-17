CREATE TABLE tarea_d(
    id_tarea INT AUTO_INCREMENT,
    id_docente INT NOT NULL,
    id_categoria INT NOT NULL,
    c_titulo VARCHAR(60) NOT NULL,
    c_url_archivo TEXT,
    c_observacion TEXT,
    t_fecha_hora_entrega TIMESTAMP,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_tarea)
);


ALTER TABLE tarea_d ADD CONSTRAINT tarea_d_docente_d_id_alumno FOREIGN KEY (id_docente) REFERENCES docente_d (id_docente);
ALTER TABLE tarea_d ADD CONSTRAINT tarea_d_categoria_d_id_categoria FOREIGN KEY (id_categoria) REFERENCES categoria_d (id_categoria);
ALTER TABLE tarea_d ADD CONSTRAINT tarea_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE tarea_d ADD CONSTRAINT tarea_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

CREATE TABLE respuesta_d(
    id_respuesta INT AUTO_INCREMENT,
    c_url_archivo TEXT,
    c_observacion TEXT,
    c_calificacion VARCHAR(20),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_respuesta)
);

ALTER TABLE respuesta_d ADD CONSTRAINT respuesta_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE respuesta_d ADD CONSTRAINT respuesta_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);



CREATE TABLE alumno_tarea_respuesta_p(
    id_alumno_docente_tarea INT AUTO_INCREMENT,
    id_tarea INT NOT NULL,
    id_alumno INT NOT NULL,
    c_estado VARCHAR(4) NOT NULL,
    id_respuesta INT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_alumno_docente_tarea)
);

ALTER TABLE alumno_tarea_respuesta_p ADD CONSTRAINT alumno_tarea_respuesta_p_tarea_d_id_tarea FOREIGN KEY (id_tarea) REFERENCES tarea_d (id_tarea);
ALTER TABLE alumno_tarea_respuesta_p ADD CONSTRAINT alumno_tarea_respuesta_p_alumno_d_id_alumno FOREIGN KEY (id_alumno) REFERENCES alumno_d (id_alumno);
ALTER TABLE alumno_tarea_respuesta_p ADD CONSTRAINT alumno_tarea_respuesta_p_respuesta_d_id_respuesta FOREIGN KEY (id_respuesta) REFERENCES respuesta_d (id_respuesta);

ALTER TABLE alumno_tarea_respuesta_p ADD CONSTRAINT alumno_tarea_respuesta_p_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE alumno_tarea_respuesta_p ADD CONSTRAINT alumno_tarea_respuesta_p_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

CREATE TABLE comentario_d(
    id_comentario INT AUTO_INCREMENT,
    id_tarea INT NOT NULL,
    id_usuario INT NOT NULL,
    c_descripcion TEXT NOT NULL,
    id_comentario_referencia INT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_comentario)
);


ALTER TABLE comentario_d ADD CONSTRAINT comentario_d_tarea_d_id_tarea FOREIGN KEY (id_tarea) REFERENCES tarea_d (id_tarea);
ALTER TABLE comentario_d ADD CONSTRAINT comentario_d_users_id FOREIGN KEY (id_usuario) REFERENCES users (id);
ALTER TABLE comentario_d ADD CONSTRAINT comentario_d_comentario_d_id_comentario FOREIGN KEY (id_comentario_referencia) REFERENCES comentario_d (id_comentario);

ALTER TABLE comentario_d ADD CONSTRAINT comentario_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE comentario_d ADD CONSTRAINT comentario_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);