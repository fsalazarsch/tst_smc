-- a. Consulta para saber cuántos profesores son hombres o mujeres por departamento
SELECT 
    d.nombre AS departamento,
    p.sexo,
    COUNT(*) AS total_profesores
FROM profesor pr
JOIN persona p ON pr.id_profesor = p.id
JOIN departamento d ON pr.id_departamento = d.id
GROUP BY d.nombre, p.sexo;

-- b. Número de alumnos que nacieron en el mismo año
SELECT 
    YEAR(p.fecha_nacimiento) AS año_nacimiento,
    COUNT(*) AS total_alumnos
FROM persona p
JOIN alumno_se_matricula_asignatura a ON p.id = a.id_alumno
GROUP BY YEAR(p.fecha_nacimiento)
ORDER BY total_alumnos DESC;

-- c. Número de alumnos por grado
SELECT 
    g.nombre AS grado,
    COUNT(DISTINCT a.id_alumno) AS total_alumnos
FROM grado g
JOIN asignatura asig ON g.id = asig.id_grado
JOIN alumno_se_matricula_asignatura a ON asig.id = a.id_asignatura
GROUP BY g.nombre;

-- d. Asignatura con más alumnos registrados
SELECT 
    asig.nombre AS asignatura,
    COUNT(a.id_alumno) AS total_alumnos
FROM asignatura asig
JOIN alumno_se_matricula_asignatura a ON asig.id = a.id_asignatura
GROUP BY asig.nombre
ORDER BY total_alumnos DESC
LIMIT 1;

-- e. Listado completo de asignaturas y su profesor asignado
SELECT 
    asig.nombre AS asignatura,
    CONCAT(p.nombre, ' ', p.apellido1, ' ', p.apellido2) AS profesor
FROM asignatura asig
JOIN profesor pr ON asig.id_profesor = pr.id_profesor
JOIN persona p ON pr.id_profesor = p.id
ORDER BY asig.nombre;
