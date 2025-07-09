-- Script para importar datos masivos desde usuarios_censo_direcciones_fake.csv
-- AJUSTA la ruta del archivo CSV según corresponda en tu sistema

SET foreign_key_checks = 0;

-- Importar usuarios
LOAD DATA LOCAL INFILE 'C:/Users/panpatuhambre/Desktop/GI_Elecciones/elecciones/usuarios_censo_direcciones_fake.csv'
INTO TABLE usuario
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(NIF, @contrasenya, @iddir, @clave, @nombre, @apellidos, @fechanac, @sexo, @provincia, @ciudad, @cpostal, @nomvia, @numero, @bis, @piso, @bloque, @puerta, @correo)
SET 
  CONTRASENYA = @contrasenya,
  NOMBREUSUARIO = NIF,
  correo = @correo,
  votado = 0,
  created_at = NOW(),
  updated_at = NOW();

-- Importar direcciones
LOAD DATA LOCAL INFILE 'C:/Users/panpatuhambre/Desktop/GI_Elecciones/elecciones/usuarios_censo_direcciones_fake.csv'
INTO TABLE direcciones
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@nif, @contrasenya, IDDIRECCION, @clave, @nombre, @apellidos, @fechanac, @sexo, PROVINCIA, CIUDAD, CPOSTAL, NOMVIA, NUMERO, BIS, PISO, BLOQUE, PUERTA);

-- Importar censo
LOAD DATA LOCAL INFILE 'C:/Users/panpatuhambre/Desktop/GI_Elecciones/elecciones/usuarios_censo_direcciones_fake.csv'
INTO TABLE censo
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(NIF, @contrasenya, IDDIRECCION, CLAVE, NOMBRE, APELLIDOS, FECHANAC, SEXO, @provincia, @ciudad, @cpostal, @nomvia, @numero, @bis, @piso, @bloque, @puerta);

SET foreign_key_checks = 1; 