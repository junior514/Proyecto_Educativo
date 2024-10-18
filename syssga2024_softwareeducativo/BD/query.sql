

CREATE TABLE docentes(
    idDocente INT PRIMARY KEY AUTO_INCREMENT,
    nroDocDoc VARCHAR (15) NOT NULL,
    nomDoc VARCHAR (191) NOT NULL,
    telDoc VARCHAR (15),
    dirDoc VARCHAR (80),
    espDoc VARCHAR (80),
    email VARCHAR (191) NOT NULL UNIQUE,
    password VARCHAR (191) NOT NULL 
);

CREATE TABLE cursos(
    idCurso INT PRIMARY KEY AUTO_INCREMENT,
    nomCur VARCHAR (250) NOT NULL UNIQUE,
    estadoCur VARCHAR(45) NOT NULL
);

CREATE TABLE estudiantes(
    idEstudiante INT PRIMARY KEY AUTO_INCREMENT,
    nroDocEst VARCHAR (15) NOT NULL UNIQUE,
    nomEst VARCHAR (191) NOT NULL,
    telEst VARCHAR (15),
    dirEst VARCHAR (80),
    generoEst VARCHAR (45),
    fotoEst VARCHAR(250),
    f_nacimiento DATE,
    email VARCHAR (191) NOT NULL,
    password VARCHAR (191) NOT NULL,
    fecCre DATETIME NOT NULL
);

CREATE TABLE matriculas (
    idMatricula INT PRIMARY KEY AUTO_INCREMENT,
    idCurso INT NOT NULL,
    idEstudiante INT NOT NULL,
    fecMat DATETIME NOT NULL,
    precioMat DECIMAL (18,2),
    precioMod DECIMAL (18,2),
    nroCuotas INT,
    fechaPrimeraCuota DATE NOT NULL,
    id INT NOT NULL,
    FOREIGN KEY(idCurso) REFERENCES cursos (idCurso),
    FOREIGN KEY(idEstudiante) REFERENCES estudiantes (idEstudiante),
    FOREIGN KEY(id) REFERENCES users (id)
);
-- En caso cambie de docente, solo se visualizara el nombre del último docente en los reportes
-- Se creara 12 modulos para cada estudiante que se matricule, Si





CREATE TABLE grupos (
    idGrupo INT PRIMARY KEY AUTO_INCREMENT,
    nombreGrupo VARCHAR(60) NOT NULL,
    idCurso INT NOT NULL,
    idDocente INT NOT NULL,
    fechCreacionGru DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    UNIQUE (nombreGrupo, idCurso, idDocente),
    FOREIGN KEY(idCurso) REFERENCES cursos (idCurso),
    FOREIGN KEY(idDocente) REFERENCES docentes (idDocente)
);

CREATE TABLE modulos(
    idModulo INT PRIMARY KEY AUTO_INCREMENT,
    nroModulo INT NOT NULL,
    idMatricula INT NOT NULL,
    nota1 VARCHAR(80),
    nota2 VARCHAR(80),
    nota3 VARCHAR(80),
    notaExamen DECIMAL(18,2),
    notaRecuperacion DECIMAL(18,2),
    idGrupo INT NOT NULL,
    FOREIGN KEY(idMatricula) REFERENCES matriculas (idMatricula),
    FOREIGN KEY(idGrupo) REFERENCES grupos (idGrupo)
);

ALTER TABLE modulos ADD FOREIGN KEY(idGrupo) REFERENCES grupos (idGrupo);

CREATE TABLE productos(
    idProducto INT PRIMARY KEY AUTO_INCREMENT,
    nombreProducto VARCHAR(191) NOT NULL,
    UNIQUE(nombreProducto)
);

-- 21 de agosto 2023
CREATE TABLE creditos(
    idCredito INT PRIMARY KEY AUTO_INCREMENT,
    fechaCre DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    valorCre DECIMAL(18,2) NOT NULL,
    pagoAnticipado DECIMAL(18,2) NOT NULL,
    fechaPrimCuota DATE NOT NULL,
    periodoCuotas VARCHAR(45) NOT NULL,
    nroCuotas INT NOT NULL,
    observacionesCre TEXT,
    idMatricula INT NOT NULL,
    FOREIGN KEY(idMatricula) REFERENCES matriculas (idMatricula)
);

CREATE TABLE tipos_descuento(
    idTipoDescuento INT PRIMARY KEY AUTO_INCREMENT,
    nombreTP VARCHAR (60) NOT NULL UNIQUE,
    valorPorcentaje INT NOT NULL
);

CREATE TABLE concepto_creditos (
    idConceptoCredito INT PRIMARY KEY AUTO_INCREMENT,
    valorUnidad DECIMAL(18,2) NOT NULL,
    cantidad INT NOT NULL,
    idTipoDescuento INT NOT NULL,
    valorDescontado DECIMAL(18,2) NOT NULL,
    valorTotal DECIMAL(18,2) NOT NULL,
    idProducto INT NOT NULL,
    idCredito INT NOT NULL,
    FOREIGN KEY(idTipoDescuento) REFERENCES tipos_descuento (idTipoDescuento),
    FOREIGN KEY(idProducto) REFERENCES productos (idProducto),
    FOREIGN KEY(idCredito) REFERENCES creditos (idCredito)
);

CREATE TABLE cuotas_a_pagar (
    idCuotaAPagar INT PRIMARY KEY AUTO_INCREMENT,
    fechAPagar DATE NOT NULL,
    montoAPagar DECIMAL (18,2) NOT NULL,
    idCredito INT NOT NULL,
    FOREIGN KEY(idCredito) REFERENCES creditos (idCredito)
);

CREATE TABLE formas_pago (
    idFormaPago INT PRIMARY KEY AUTO_INCREMENT,
    nombreFP VARCHAR(60) NOT NULL UNIQUE
);


CREATE TABLE pagos (
    idPagos INT PRIMARY KEY AUTO_INCREMENT,
    fechaPago DATE NOT NULL,
    fechaAsiento DATE NOT NULL,
    detallePago TEXT,
    valorPago DECIMAL(18,2),
    idFormaPago INT NOT NULL,
    idCredito INT NOT NULL,
    FOREIGN KEY(idCredito) REFERENCES creditos (idCredito),
    FOREIGN KEY(idFormaPago) REFERENCES formas_pago (idFormaPago)
);

-- 1 de Septiembre
CREATE TABLE observaciones_creditos (
    idObservacion INT PRIMARY KEY AUTO_INCREMENT,
    fechaObs DATE NOT NULL,
    detalleObs TEXT NOT NULL,
    idCredito INT NOT NULL,
    id INT NOT NULL,
    FOREIGN KEY(idCredito) REFERENCES creditos (idCredito)
    FOREIGN KEY(id) REFERENCES users (id)
);

ALTER TABLE observaciones_creditos ADD FOREIGN KEY(idCredito) REFERENCES creditos (idCredito);

CREATE TABLE ajustes (
    idAjuste  INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    direccion VARCHAR(191) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    ruc VARCHAR(11) NOT NULL,
    correo VARCHAR(91),
    logo VARCHAR(191)
);

ALTER TABLE cursos DROP FOREIGN KEY cursos_ibfk_1

-- Cambiar la columna de nroDocEst
ALTER TABLE estudiantes
ADD CONSTRAINT nroDoc UNIQUE (nroDoc);

ALTER TABLE docentes
ADD CONSTRAINT nroDoc UNIQUE (nroDoc);

-- Orden para eliminar registros
DELETE FROM comprobantes;
DELETE FROM pagos;
DELETE FROM cuotas_a_pagar;
DELETE FROM observaciones_creditos;
DELETE FROM concepto_creditos;
DELETE FROM creditos;
DELETE FROM modulos;
DELETE FROM matriculas;
DELETE FROM detalle_asistencias;
DELETE FROM asistencias;
DELETE FROM estudiantes;


CREATE TABLE asistencias(
    idAsistencia INT PRIMARY KEY AUTO_INCREMENT,
    idGrupo INT NOT NULL,
    nroModulo INT NOT NULL,
    observacion VARCHAR(250),
    fecha DATE NOT NULL,
    FOREIGN KEY (idGrupo) REFERENCES grupos (idGrupo)
);

CREATE TABLE detalle_asistencias(
    idDetalleAsistencia INT PRIMARY KEY AUTO_INCREMENT,
    idEstudiante INT NOT NULL,
    estado VARCHAR(40) NOT NULL,
    observacion VARCHAR(250),
    idAsistencia INT NOT NULL,
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes (idEstudiante),
    FOREIGN KEY (idAsistencia) REFERENCES asistencias (idAsistencia)
);

-- 05 de Octubre del 2023

CREATE TABLE lecciones (
    idLeccion INT PRIMARY KEY AUTO_INCREMENT,
    nombreLeccion VARCHAR(91) NOT NULL,
    nroModulo INT NOT NULL,
    idGrupo INT,
    FOREIGN KEY (idGrupo) REFERENCES grupos (idGrupo)
);

CREATE TABLE recursos (
    idRecurso INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(91) NOT NULL,
    descripcion VARCHAR(250),
    fechaInicio DATE,
    horaInicio TIME,
    fechaFin DATE,
    horaFin TIME,
    fechaCreacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tipo VARCHAR(80) NOT NULL,
    archivo VARCHAR(250),
    idLeccion INT NOT NULL,
    FOREIGN KEY (idLeccion) REFERENCES lecciones (idLeccion)
);

CREATE TABLE entrega_tareas (
    idEntregaTarea INT PRIMARY KEY AUTO_INCREMENT,
    fechaEntrega DATETIME NOT NULL,
    comentarioEstudiante VARCHAR(250),
    archivoEntega VARCHAR (250) NOT NULL,
    fechaRevision DATETIME, 
    nota DECIMAL(18,1), 
    comentarioDocente VARCHAR(250),
    idRecurso INT NOT NULL,
    idEstudiante INT NOT NULL,
    FOREIGN KEY (idRecurso) REFERENCES recursos (idRecurso),
    FOREIGN KEY (idEstudiante) REFERENCES estudiantes (idEstudiante)
);