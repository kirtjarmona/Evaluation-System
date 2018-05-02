SELECT facultyid, COUNT(DISTINCT facultyid) 
	FROM srgb.semsubject SS, fes.ratings FR
WHERE SS.sy = '2017-2018'
AND SS.sem = '2'
AND SS.facultyid IS NOT null
AND SS.facultyid = FR.student_id
GROUP BY SS.facultyid
===========================================
SELECT facultyid, COUNT(DISTINCT facultyid) 
	FROM srgb.semsubject
WHERE sy = '2017-2018'
AND sem = '2'
AND facultyid IS NOT null
GROUP BY facultyid
===========================================



SELECT SS.studid, SS.studlevel, SS.studmajor, ST.studfirstname FROM srgb.semstudent SS, srgb.student ST
WHERE ST.studid = SS.studid
AND studmajor = 'BSIT'
AND sem = '2'
AND sy = '2017-2018'
AND studlevel = 4
ORDER BY sy ASC, sem ASC, studid ASC LIMIT 100 

-- =========================================================

SELECT sem, sy FROM srgb.semester
ORDER BY sy DESC, sem DESC LIMIT 1


-- =========================================================

SELECT DISTINCT(FF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
FROM srgb.department SD, fes.faculty FF, pis.employee PE, srgb.semsubject SS
WHERE FF.empid = PE.empid
AND FF.deptcode = 'IT'
AND FF.deptcode = SD.deptcode
AND PE.empid = SS.facultyid
AND SS.sy = '2017-2018'
AND SS.sem = '2'
ORDER BY PE.lastname ASC

===============================

SELECT COUNT(studid) FROM srgb.semstudent
WHERE sem = '1' AND sy = '2017-2018'
=======================

SELECT * FROM srgb.student
ORDER BY studid ASC LIMIT 100
========================
SELECT COUNT(studid), studmajor FROM srgb.semstudent
WHERE sem = '1' AND sy = '2017-2018' AND studmajor LIKE '%AB%'
GROUP BY studmajor


===============
DEPARTMENT HEADS!
SELECT * FROM srgb.department
ORDER BY deptcode ASC 

UPDATE ALL

UPDATE srgb.department
	SET deptchairman='74-3203-1'
	WHERE deptcode='IT';
====================

SELECT COUNT(studid), studmajor FROM srgb.semstudent
WHERE sem = '2'
AND sy= '2017-2018'
AND registered = true
GROUP BY studmajor