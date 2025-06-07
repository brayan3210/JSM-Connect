-- Esquema de base de datos para plataforma de servicios
-- Laravel 11 + MySQL

-- Tabla de usuarios (para administradores y clientes)
CREATE TABLE usuarios (
    id_usuario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    tipo_documento VARCHAR(50) NOT NULL,
    numero_documento VARCHAR(30) NOT NULL UNIQUE,
    genero VARCHAR(20) NOT NULL,
    profesion VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    es_admin BOOLEAN DEFAULT 0 NOT NULL, -- 0: cliente, 1: administrador
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT 1 NOT NULL
);

-- Tabla de categorías predefinidas
CREATE TABLE categorias (
    id_categoria BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT 1 NOT NULL
);

-- Tabla de preferencias de usuarios
CREATE TABLE preferencias_usuarios (
    id_preferencia BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NOT NULL,
    hobby VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla de categorías de interés de los usuarios
CREATE TABLE intereses_categorias (
    id_interes BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NOT NULL,
    id_categoria BIGINT UNSIGNED NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario_categoria (id_usuario, id_categoria)
);

-- Tabla de especialidades de los usuarios
CREATE TABLE especialidades_usuarios (
    id_especialidad BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NOT NULL,
    id_categoria BIGINT UNSIGNED NOT NULL,
    descripcion TEXT NOT NULL,
    experiencia_años INT DEFAULT 0,
    tarifa_hora DECIMAL(10,2) DEFAULT 0,
    disponible BOOLEAN DEFAULT 1 NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario_categoria_especialidad (id_usuario, id_categoria)
);

-- Tabla de servicios ofrecidos
CREATE TABLE servicios (
    id_servicio BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NOT NULL, -- Usuario que ofrece el servicio
    id_categoria BIGINT UNSIGNED NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    duracion_estimada VARCHAR(50) NULL, -- Ejemplo: "2 horas", "1 semana"
    disponible BOOLEAN DEFAULT 1 NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE
);

-- Tabla de contactos/solicitudes de servicio
CREATE TABLE solicitudes_servicios (
    id_solicitud BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_servicio BIGINT UNSIGNED NOT NULL,
    id_usuario_solicitante BIGINT UNSIGNED NOT NULL, -- Usuario que solicita el servicio
    id_usuario_proveedor BIGINT UNSIGNED NOT NULL, -- Usuario que ofrece el servicio
    mensaje TEXT NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada') DEFAULT 'pendiente',
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_solicitante) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_proveedor) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla de valoraciones de servicios
CREATE TABLE valoraciones (
    id_valoracion BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_solicitud BIGINT UNSIGNED NOT NULL,
    id_usuario_evaluador BIGINT UNSIGNED NOT NULL, -- Usuario que evalúa
    puntuacion INT NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
    comentario TEXT NULL,
    fecha_valoracion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_solicitud) REFERENCES solicitudes_servicios(id_solicitud) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_evaluador) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    UNIQUE KEY unico_valoracion_solicitud (id_solicitud, id_usuario_evaluador)
);

-- Tabla para datos estadísticos (para facilitar consultas administrativas)
CREATE TABLE estadisticas (
    id_estadistica BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL, -- 'usuarios_genero', 'usuarios_categoria', etc.
    valor VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de mensajes entre usuarios
CREATE TABLE mensajes (
    id_mensaje BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_remitente BIGINT UNSIGNED NOT NULL,
    id_destinatario BIGINT UNSIGNED NOT NULL,
    id_solicitud BIGINT UNSIGNED NULL, -- Puede estar relacionado o no a una solicitud
    contenido TEXT NOT NULL,
    leido BOOLEAN DEFAULT 0 NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_remitente) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_destinatario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_solicitud) REFERENCES solicitudes_servicios(id_solicitud) ON DELETE SET NULL
);

-- Inserción de categorías predefinidas de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES 
('Programación', 'Desarrollo de software, aplicaciones web y móviles'),
('Diseño Gráfico', 'Diseño de logos, banners, ilustraciones y material visual'),
('Marketing Digital', 'Estrategias de marketing en redes sociales y plataformas digitales'),
('Traducción', 'Servicios de traducción de documentos e interpretación'),
('Redacción', 'Creación de contenido, artículos, blogs y material escrito'),
('Fotografía', 'Servicios de fotografía profesional para eventos y productos'),
('Contabilidad', 'Servicios contables, impuestos y finanzas personales'),
('Asesoría Legal', 'Consultoría y asesoría en temas legales'),
('Educación', 'Tutoría, clases particulares y formación'),
('Salud', 'Servicios relacionados con la salud y el bienestar');

-- Creación de un usuario administrador inicial
INSERT INTO usuarios (nombre, apellidos, tipo_documento, numero_documento, genero, profesion, email, telefono, password, es_admin)
VALUES ('Admin', 'Sistema', 'Cédula', '1000000000', 'Otro', 'Administrador de Sistemas', 'admin@plataforma.com', '1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1); -- password: password 