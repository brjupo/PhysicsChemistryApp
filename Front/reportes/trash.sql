SELECT id_usuario, puntuacion FROM `puntuacion` 
WHERE id_leccion = 52 AND tipo = 'PP' AND tiempo 
BETWEEN '2020-07-23 07:00:00' AND '2020-07-26 22:57:00'

SELECT DISTINCT alumno.matricula, alumno_grupo.id_alumno 
FROM alumno_grupo INNER JOIN alumno ON alumno.id_alumno = alumno_grupo.id_alumno 
WHERE alumno_grupo.id_grupo = a;

SELECT alumno.id_alumno, puntuacion.puntuacion FROM puntuacion INNER JOIN alumno 
ON alumno.id_usuario = puntuacion.id_usuario
WHERE id_leccion = 52 AND tipo = 'PP' AND tiempo 
BETWEEN '2020-07-23 07:00:00' AND '2020-07-26 22:57:00'