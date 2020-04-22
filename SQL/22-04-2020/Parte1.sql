CREATE TABLE permitido_m(
    id_permitido INT AUTO_INCREMENT,
    c_ruc CHAR(11) NOT NULL,
    c_estado CHAR(4) NOT NULL,
    PRIMARY KEY(id_permitido)
);


INSERT INTO permitido_m(c_ruc,c_estado) VALUES('10717618870','NOAC'),('10717618872','ACTI');