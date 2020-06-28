CREATE TABLE archivo_tarea_d(
  id_archivo INT AUTO_INCREMENT,
  id_tarea INT NOT NULL,
  c_url_archivo TEXT NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  creador INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  modificador INT,
  updated_at TIMESTAMP,
  PRIMARY KEY(id_archivo)
);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_tarea_d_id_tarea FOREIGN KEY (id_tarea) REFERENCES tarea_d (id_tarea);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE archivo_tarea_d ADD CONSTRAINT archivo_tarea_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
