--creado = true
CREATE TABLE tipo_documento_m(
    id_tipo_documento INT AUTO_INCREMENT,
    c_codigo_sunat VARCHAR(191),
    c_nombre VARCHAR(191),
    b_tipo TINYINT(1) COMMENT '0 = comprobantes,1 = notas',
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_tipo_documento)
);

ALTER TABLE tipo_documento_m ADD CONSTRAINT tipo_documento_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE tipo_documento_m ADD CONSTRAINT tipo_documento_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = true
CREATE TABLE moneda_m(
    id_moneda INT AUTO_INCREMENT,
    c_codigo_sunat VARCHAR(191),
    c_nombre VARCHAR(191),
    c_simbolo VARCHAR(191),
    b_principal TINYINT(1) NOT NULL COMMENT '0 = no utiliza la plataforma,1 = utilizada en forma general',
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_moneda)    
);

ALTER TABLE moneda_m ADD CONSTRAINT moneda_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE moneda_m ADD CONSTRAINT moneda_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
--creado = true
CREATE TABLE tributo_m(
    id_tributo INT AUTO_INCREMENT,
    c_codigo_sunat VARCHAR(191),
    c_nombre VARCHAR(191),
    c_codigo_afectacion VARCHAR(191),
    n_porcentaje INT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_tributo)
);

ALTER TABLE tributo_m ADD CONSTRAINT tributo_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE tributo_m ADD CONSTRAINT tributo_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = true

CREATE TABLE serie_d(
    id_serie INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    id_tipo_documento INT NOT NULL,
    c_documento_afectacion CHAR(1) NOT NULL COMMENT 'F = Factura, B= Boleta',
    c_serie VARCHAR(191) NOT NULL,
    b_principal TINYINT(1),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_serie)
);
ALTER TABLE serie_d ADD CONSTRAINT serie_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE serie_d ADD CONSTRAINT serie_d_tipo_documento_m_id_tipo_documento FOREIGN KEY (id_tipo_documento) REFERENCES tipo_documento_m (id_tipo_documento);
ALTER TABLE serie_d ADD CONSTRAINT serie_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE serie_d ADD CONSTRAINT serie_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = true

CREATE TABLE documento_identidad_m(
    id_documento_identidad INT AUTO_INCREMENT,
    c_codigo_sunat VARCHAR(191),
    c_nombre VARCHAR(191),
    c_abreviatura VARCHAR(191),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_documento_identidad)
);
ALTER TABLE documento_identidad_m ADD CONSTRAINT documento_identidad_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE documento_identidad_m ADD CONSTRAINT documento_identidad_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
--creado = true
CREATE TABLE producto_servicio_d(
    id_producto_servicio INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    c_codigo VARCHAR(191) NOT NULL,
    c_tipo_codigo VARCHAR(191) NOT NULL COMMENT 'GENERADO | MANUAL',
    c_nombre VARCHAR(191) NOT NULL,
    c_tipo VARCHAR(191) NOT NULL COMMENT 'PRODUCTO | SERVICIO',
    c_unidad VARCHAR(191),
    c_unidad_sunat VARCHAR(191),
    n_precio_sin_igv DECIMAL(10,2),
    n_precio_con_igv DECIMAL(10,2),
    id_tributo INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_producto_servicio)
);

ALTER TABLE producto_servicio_d ADD CONSTRAINT producto_servicio_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE producto_servicio_d ADD CONSTRAINT producto_servicio_d_tributo_m_id_tributo FOREIGN KEY (id_tributo) REFERENCES tributo_m (id_tributo);

ALTER TABLE producto_servicio_d ADD CONSTRAINT UK_c_codigo_id_colegio UNIQUE (c_codigo,id_colegio);
ALTER TABLE producto_servicio_d ADD CONSTRAINT UK_c_nombre_id_colegio UNIQUE (c_nombre,id_colegio);

ALTER TABLE producto_servicio_d ADD CONSTRAINT producto_servicio_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE producto_servicio_d ADD CONSTRAINT producto_servicio_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);


--creado = true
CREATE TABLE motivo_nota_m(
    id_motivo_nota INT AUTO_INCREMENT,
    b_tipo TINYINT(1) COMMENT '0 = credito, 1 = debito',
    c_codigo_sunat VARCHAR(191),
    c_nombre VARCHAR(191),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_motivo_nota)
);

ALTER TABLE motivo_nota_m ADD CONSTRAINT motivo_nota_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE motivo_nota_m ADD CONSTRAINT motivo_nota_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
--creado = true
CREATE TABLE tipo_impresion_m(
    id_tipo_impresion INT AUTO_INCREMENT,
    c_nombre VARCHAR(191),
    c_referencia VARCHAR(191),
    c_tipo VARCHAR(191),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_tipo_impresion)
);

ALTER TABLE tipo_impresion_m ADD CONSTRAINT tipo_impresion_m_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE tipo_impresion_m ADD CONSTRAINT tipo_impresion_m_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado =  true
CREATE TABLE preferencia_d(
    id_preferencia INT AUTO_INCREMENT,
    id_tipo_documento INT NOT NULL,
    id_tipo_impresion INT NOT NULL,
    id_serie INT NOT NULL,
    id_usuario INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_preferencia)
);
ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_tipo_documento_m_id_documento FOREIGN KEY (id_tipo_documento) REFERENCES tipo_documento_m (id_tipo_documento);
ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_tipo_impresion_m_id_tipo_impresion FOREIGN KEY (id_tipo_impresion) REFERENCES tipo_impresion_m (id_tipo_impresion);
ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_serie_d_id_serie FOREIGN KEY (id_serie) REFERENCES serie_d (id_serie);
ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_users_id_usuario FOREIGN KEY (id_usuario) REFERENCES users (id);

ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE preferencia_d ADD CONSTRAINT preferencia_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = false--falta implementar relaciones de otras entidades con esta tabla en Eloquent
CREATE TABLE comprobante_d(
    id_comprobante INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    id_serie INT NOT NULL,
    id_alumno INT,
    id_tipo_documento INT NOT NULL,
    id_moneda INT NOT NULL,
    n_numero INT NOT NULL,
    c_nombre_receptor VARCHAR(191),
    id_documento_identidad INT NOT NULL,
    c_numero_documento_identidad VARCHAR(191),
    c_direccion_receptor VARCHAR(191),
    c_ubigeo_receptor VARCHAR(191),
    c_email_receptor VARCHAR(191),
    c_telefono_receptor VARCHAR(191),
    t_fecha_vencimiento DATE,
    c_observaciones VARCHAR(255),
    id_tipo_impresion INT NOT NULL,
    b_envio_automatico_email TINYINT(1),
    n_total_operacion_gravada numeric,
    n_total_operacion_inafecta numeric,
    n_total_operacion_exonerada numeric,
    n_total_operacion_gratuita numeric,
    n_total_descuento numeric,
    n_total_igv numeric,
    n_total_icbper numeric,
    n_total numeric,
    j_json_send TEXT,
    j_json_return TEXT,
    c_external_id VARCHAR(191),
    c_pdf TEXT,
    c_xml TEXT,
    c_cdr TEXT,
    c_estado_sunat VARCHAR(191),
    b_estado_comprobado TINYINT(1),
    c_tipo_anulacion VARCHAR(191),
    c_motivo_anulacion VARCHAR(255),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_comprobante)
);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_serie_d_id_serie FOREIGN KEY (id_serie) REFERENCES serie_d (id_serie);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_alumno_d_id_alumno FOREIGN KEY (id_alumno) REFERENCES alumno_d (id_alumno);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_tipo_documento_m_id_tipo_documento FOREIGN KEY (id_tipo_documento) REFERENCES tipo_documento_m (id_tipo_documento);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_moneda_m_id_moneda FOREIGN KEY (id_moneda) REFERENCES moneda_m (id_moneda);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_documento_identidad_m_id_documento_identidad FOREIGN KEY (id_documento_identidad) REFERENCES documento_identidad_m (id_documento_identidad);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_tipo_impresion_m_id_tipo_impresion FOREIGN KEY (id_tipo_impresion) REFERENCES tipo_impresion_m (id_tipo_impresion);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE comprobante_d ADD CONSTRAINT comprobante_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);
ALTER TABLE comprobante_d ADD CONSTRAINT UK_n_numero_id_serie_id_colegio UNIQUE (n_numero,id_serie,id_colegio);

--creado = true

CREATE TABLE detalle_comprobante_d(
    id_detalle_comprobante INT AUTO_INCREMENT,
    id_comprobante INT NOT NULL,
    id_producto INT NOT NULL,
    c_codigo_producto VARCHAR(191),
    c_nombre_producto VARCHAR(191),
    c_unidad_producto VARCHAR(191),
    c_tributo_producto VARCHAR(191),
    c_informacion_adicional VARCHAR(255),
    b_tipo_detalle TINYINT(1) COMMENT '0 = venta,1 = gratuito',
    n_cantidad integer,
    n_valor_unitario NUMERIC,
    n_precio_unitario NUMERIC,
    n_porcentaje_igv INT COMMENT '1-100',
    n_total_base NUMERIC,
    n_total_igv NUMERIC,
    n_total_icbper NUMERIC,
    n_total_impuesto NUMERIC,
    n_total_detalle NUMERIC,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_detalle_comprobante)
);
ALTER TABLE detalle_comprobante_d ADD CONSTRAINT detalle_comprobante_d_comprobante_d_id_comprobante FOREIGN KEY (id_comprobante) REFERENCES comprobante_d (id_comprobante);
ALTER TABLE detalle_comprobante_d ADD CONSTRAINT detalle_comprobante_d_producto_servicio_d_id_producto FOREIGN KEY (id_producto) REFERENCES producto_servicio_d (id_producto_servicio);

ALTER TABLE detalle_comprobante_d ADD CONSTRAINT detalle_comprobante_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE detalle_comprobante_d ADD CONSTRAINT detalle_comprobante_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = false falta implementar relaciones de otras entidades con esta tabla en Eloquent
CREATE TABLE nota_d(
    id_nota INT AUTO_INCREMENT,
    id_colegio INT NOT NULL,
    id_alumno INT,
    id_comprobante INT NOT NULL,
    id_tipo_documento INT NOT NULL,
    id_moneda INT NOT NULL,
    id_serie INT NOT NULL,
    n_numero INT NOT NULL,
    id_motivo_nota INT NOT NULL,
    c_observacion_motivo VARCHAR(255),
    c_nombre_receptor VARCHAR(191),
    id_documento_identidad INT NOT NULL,
    c_numero_documento_identidad VARCHAR(191),
    c_direccion_receptor VARCHAR(191),
    c_ubigeo_receptor VARCHAR(6),
    c_email_receptor VARCHAR(191),
    c_telefono_receptor VARCHAR(191),
    c_observaciones VARCHAR(255),
    id_tipo_impresion INT NOT NULL,
    b_envio_automatico_email TINYINT(1),
    n_total_operacion_gravada numeric,
    n_total_operacion_inafecta numeric,
    n_total_operacion_exonerada numeric,
    n_total_operacion_gratuita numeric,
    n_total_descuento numeric,
    n_total_igv numeric,
    n_total_icbper numeric,
    n_total numeric,
    j_json_send TEXT,
    j_json_return TEXT,
    c_external_id VARCHAR(191),
    c_pdf TEXT,
    c_xml TEXT,
    c_cdr TEXT,
    c_estado_sunat VARCHAR(191),
    b_estado_comprobado TINYINT(1),
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_nota)
);

ALTER TABLE nota_d ADD CONSTRAINT nota_d_colegio_m_id_colegio FOREIGN KEY (id_colegio) REFERENCES colegio_m (id_colegio);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_alumno_d_id_alumno FOREIGN KEY (id_alumno) REFERENCES alumno_d (id_alumno);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_comprobante_d_id_comprobante FOREIGN KEY (id_comprobante) REFERENCES comprobante_d (id_comprobante);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_tipo_documento_m_id_tipo_documento FOREIGN KEY (id_tipo_documento) REFERENCES tipo_documento_m (id_tipo_documento);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_moneda_m_id_moneda FOREIGN KEY (id_moneda) REFERENCES moneda_m (id_moneda);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_tipo_serie_d_id_serie FOREIGN KEY (id_serie) REFERENCES serie_d (id_serie);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_motivo_nota_m_id_motivo_nota FOREIGN KEY (id_motivo_nota) REFERENCES motivo_nota_m (id_motivo_nota);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_documento_identidad_m_id_documento_identidad FOREIGN KEY (id_documento_identidad) REFERENCES documento_identidad_m (id_documento_identidad);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_tipo_impresion_m_id_tipo_impresion FOREIGN KEY (id_tipo_impresion) REFERENCES tipo_impresion_m (id_tipo_impresion);
ALTER TABLE nota_d ADD CONSTRAINT UK_n_numero_id_serie_id_colegio UNIQUE (n_numero,id_serie,id_colegio);

ALTER TABLE nota_d ADD CONSTRAINT nota_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE nota_d ADD CONSTRAINT nota_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);

--creado = true
CREATE TABLE detalle_nota_d(
    id_detalle_nota INT AUTO_INCREMENT,
    id_nota INT NOT NULL,
    id_producto INT NOT NULL,
    c_codigo_producto VARCHAR(191),
    c_nombre_producto VARCHAR(191),
    c_unidad_producto VARCHAR(191),
    c_tributo_producto VARCHAR(191),
    c_informacion_adicional VARCHAR(255),
    b_tipo_detalle TINYINT(1) COMMENT '0 = venta,1 = gratuito',
    n_cantidad INT,
    n_valor_unitario NUMERIC,
    n_precio_unitario NUMERIC,
    n_porcentaje_igv INT COMMENT '1-100',
    n_total_base NUMERIC,
    n_total_igv NUMERIC,
    n_total_icbper NUMERIC,
    n_total_impuesto NUMERIC,
    n_total_detalle NUMERIC,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creador INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    modificador INT,
    updated_at TIMESTAMP,
    PRIMARY KEY(id_detalle_nota)
);

ALTER TABLE detalle_nota_d ADD CONSTRAINT detalle_nota_d_nota_d_id_nota FOREIGN KEY (id_nota) REFERENCES nota_d (id_nota);
ALTER TABLE detalle_nota_d ADD CONSTRAINT detalle_nota_d_producto_servicio_d_id_producto FOREIGN KEY (id_producto) REFERENCES producto_servicio_d (id_producto_servicio);

ALTER TABLE detalle_nota_d ADD CONSTRAINT detalle_nota_d_users_creador FOREIGN KEY (creador) REFERENCES users (id);
ALTER TABLE detalle_nota_d ADD CONSTRAINT detalle_nota_d_users_modificador FOREIGN KEY (modificador) REFERENCES users (id);