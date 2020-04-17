CREATE TABLE docente_seccion_p(
    id_docente_seccion INT AUTO_INCREMENT,
    id_docente INT NOT NULL,
    id_seccion INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_docente_seccion)
);


ALTER TABLE docente_seccion_p ADD CONSTRAINT docente_seccion_p_docente_d_id_docente FOREIGN KEY (id_docente) REFERENCES docente_d (id_docente);
ALTER TABLE docente_seccion_p ADD CONSTRAINT docente_seccion_p_seccion_d_id_seccion FOREIGN KEY (id_seccion) REFERENCES seccion_d (id_seccion);
ALTER TABLE docente_seccion_p ADD CONSTRAINT docente_seccion_p_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE docente_seccion_p ADD CONSTRAINT docente_seccion_p_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


INSERT INTO docente_seccion_p(id_docente,id_seccion,creador) VALUES
(1,1,11),
(1,2,11),
(1,3,11),
(1,4,11),
(1,5,11),
(1,6,11),
(1,7,11),
(1,8,11);


INSERT INTO docente_d(id_colegio,c_dni,c_nombre,c_nacionalidad,c_sexo,t_fecha_nacimiento,c_correo,c_telefono,c_direccion,creador) VALUES
(1,'11111111','Maria','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','Liliana','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','Roberto','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','Isaac','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','Carlos','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','xd xd xd','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11),
(1,'11111111','xd xd xd','jdjdj','F','1998-03-01','sdf@gmail.com','34234','sdfsdf',11);

