74-3203-1
Richie 
74-3203-5
Panaligan
2016-0001
Noel 
2017-00171
April 
74-3202-6
Domingo 
74-3203-3
Ria 
74-3203-9

2015-0648
Nav
https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_navbar_collapse&stacked=h
Collapse
https://www.w3schools.com/bootstrap/bootstrap_ref_js_collapse.asp
Panel
https://www.w3schools.com/bootstrap/bootstrap_panels.asp


BSA-A   BSA-H   BSAB    BSAF
BSAE    
BSAT  BSDC  BSED-BIO    

Notice: Undefined variable: condition in D:\site\FES\Admin\users.php on line 19
-- 
DAS
Chairman---- Camposano, Siverlyn M.

74-0111-6   
Adona, Rae Katherine D.
74-3245-1 
Brigole, Mabell B.
74-0047-4
Garcia, Cristina B.
74-0095-5      
Sabud, Marilou C.
74-3288-4      
Tan, Kris Kristofferson T.
2017-334       
Robante, Ma. Regina
2017-9845      
Fuentes, Harold E.
2017-4543      
Juezan, Gideon I.
EDUC-ONNAC     
Onnac Jenelyn
2017-5496      
Corpin, Cherry
2017-5497      
Escoton, Gary Dave I.
2017-2165      
Arbole, Mary Christine
DAS-CAMPOSANO  
Camposano, Israel
2017-9478      
Oling, Ailyn Joice
DAS-ALMONIA    
Almonia, Aina
01-2016        
Canada, Jovie
-- 
IEGS
Dean--- Cabrella, Jem Boy B.
Almerez, Queenie Lyn G.
Arboleda, Francisca T.
Arcon, Exenizer A.
Bello, Amelie T.
Bien, Athena R.
Noel, Helen W.
Omboy, Arlyn J.
Rosil, Cindy B.
Balacy, Garnette
Pabonita, Roberto
Sedon, Renz
Fagutao, Fernand
Reyes, Mary Lisley Jane


-- ------------------------------------------ V.1
SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
WHERE SF.empid = PE.empid
    AND SD.deptcode = 'IT'
    AND SF.deptcode = SD.deptcode
    AND PE.empid = SS.facultyid
    AND SS.sy = '2017-2018'
    AND SS.sem = '1'
-- ------------------------------------------ V.2
SELECT DISTINCT(SF.empid), PE.firstname, PE.lastname, SD.deptcoll, SD.deptcode
FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
WHERE SF.empid = PE.empid
    AND LOWER(SD.deptcode) LIKE LOWER('%IT%')
    AND SF.deptcode = SD.deptcode
    AND PE.empid = SS.facultyid
    AND SS.sy = '2016-2017'
    AND SS.sem = '2'
-- ------------------------------------------
SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode,
    SB.subjdesc, SS.facultyid,
    CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
    SB.subjdept, SD.deptcoll
FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, 
    pis.employee PS, srgb.subject SB, srgb.department SD 
WHERE S.studid = '2015-0648'  
    AND R.studid = S.studid
    AND R.sem = '1'
    AND R.sy = '2017-2018'
    AND R.subjcode = SS.subjcode
    AND R.section = SS.section
    AND SS.sem = R.sem
    AND SS.sy = R.sy
    AND SS.subjcode = SB.subjcode
    AND SSt.sy = SS.sy
    AND SSt.sem = SS.sem
    AND SSt.studid = S.studid
    AND SS.facultyid = PS.empid
    AND SB.subjdept = SD.deptcode
ORDER BY subjcode
-- ==============================================

SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode,
	SB.subjdesc, SS.facultyid,
	CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
    SB.subjdept, SD.deptcoll
FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, 
	pis.employee PS, srgb.subject SB, srgb.department SD 
WHERE S.studid = '2015-0648'  
	AND R.studid = S.studid
	AND R.sem = '1'
    AND R.sy = '2017-2018'
    AND R.subjcode = SS.subjcode
    AND R.section = SS.section
    AND SS.sem = R.sem
    AND SS.sy = R.sy
    AND SS.subjcode = SB.subjcode
    AND SSt.sy = SS.sy
    AND SSt.sem = SS.sem
    AND SSt.studid = S.studid
    AND SS.facultyid = PS.empid
    AND SB.subjdept = SD.deptcode
ORDER BY subjcode

-- ==========================
SELECT PE.empid, PE.firstname, PE.lastname, SS.subjcode, SB.subjdesc, SS.facultyid, SD.deptcode, SD.deptchairman
FROM pis.employee PE, srgb.semsubject SS, srgb.subject SB, srgb.department SD
WHERE SS.facultyid = '74-34022-9'
AND SS.facultyid = PE.empid
AND SS.sy = '2017-2018'
AND SS.sem = '1'
AND SS.subjcode = SB.subjcode
AND SB.subjdept = SD.deptcode
-----------------------------
SELECT R.sy, R.sem, SS.section, R.studid, S.studlastname, R.subjcode, SS.facultyid, 
CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name
FROM srgb.registration R, srgb.student S, srgb.semsubject SS, pis.employee PS
WHERE S.studid = '2014-0569'  
	AND R.studid = '2014-0569' 
	AND R.sem = '1'
	AND R.sy = '2017-2018'
    AND R.subjcode = SS.subjcode
    AND R.section = SS.section
    AND SS.facultyid = PS.empid

-- ------------------------------
SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode, SS.facultyid,
	CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
    SS.forcoll, SS.fordept
FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, pis.employee PS
WHERE S.studid = '2015-0648'  
	AND R.studid = S.studid
	AND R.sem = '1'
    AND R.sy = '2017-2018'
    AND R.subjcode = SS.subjcode
    AND R.section = SS.section
    AND SS.sem = R.sem
    AND SS.sy = R.sy
    AND SSt.sy = SS.sy
    AND SSt.sem = SS.sem
    AND SSt.studid = S.studid
    AND SS.facultyid = PS.empid
ORDER BY subjcode

-- -------------------------
SELECT SSt.studmajor, R.sy, R.sem, SS.section, R.studid, S.studfullname, R.subjcode, SB.subjdesc, SS.facultyid,
	CONCAT (PS.firstname, ' ' ,PS.lastname) AS Name,
    SS.forcoll, SB.subjdept
FROM srgb.registration R, srgb.student S, srgb.semstudent SSt, srgb.semsubject SS, pis.employee PS, srgb.subject SB 
WHERE S.studid = '2015-0648'  
	AND R.studid = S.studid
	AND R.sem = '1'
    AND R.sy = '2017-2018'
    AND R.subjcode = SS.subjcode
    AND R.section = SS.section
    AND SS.sem = R.sem
    AND SS.sy = R.sy
    AND SS.subjcode = SB.subjcode
    AND SSt.sy = SS.sy
    AND SSt.sem = SS.sem
    AND SSt.studid = S.studid
    AND SS.facultyid = PS.empid
ORDER BY subjcode
----------------------------------------
SELECT SF.empid, SD.deptcoll, PE.lastname, SS.subjcode
FROM srgb.department SD, srgb.faculty SF, pis.employee PE, srgb.semsubject SS
WHERE SF.empid = PE.empid
    AND SD.deptcode = 'IT'
    AND SF.deptcode = SD.deptcode
    AND PE.empid = SS.facultyid
    AND SS.sy = '2017-2018'
    AND SS.sem = '1'
ORDER BY PE.lastname ASC