-- Oracle9i SQL语句
-- Oracle9i Database Online Documentation
-- https://docs.oracle.com/pls/db92/db92.homepage

-- EXERCISES	2	JOINS

	-- 1.	Find the name and salary of employees in Luton.

	-- 2.	Join the DEPT table to the EMP table and show in department number 		order.

	-- 3.	List the names of all salesmen who work in SALES

	-- 4.	List all departments that do not have any employees.

	-- 5	For each employee whose salary exceeds his manager's salary, list the 		employee's name and salary and the manager's name and salary.	

	-- 6. 	List the employees who have BLAKE as their manager.


SELECT e.ename, e.sal FROM emp_1008610086 e,dept_1008610086 d WHERE e.deptno = d.deptno AND d.loc = 'LUTON';

SELECT *  FROM emp_1008610086 e,dept_1008610086 d WHERE e.deptno = d.deptno AND ORDER BY(d.deptno);

SELECT e.ename FROM emp_1008610086 e,dept_1008610086 d WHERE e.deptno = d.deptno AND d.dname = 'SALES'

SELECT dname FROM dept_1008610086 WHERE dname NOT IN 
	(SELECT DISTINCT d.dname FROM emp_1008610086 e,dept_1008610086 d WHERE e.deptno = d.deptno)

	
SELECT e.ename, e.sal, m.ename, m.sal FROM emp_1008610086 e,emp_1008610086 m WHERE e.sal > m.sal AND e.mgr = m.empno

SELECT * FROM emp_1008610086 WHERE mgr IN
	(SELECT empno FROM emp_1008610086 WHERE ename = 'BLAKE')
	
	/* 
	EXERCISES	6    SUB QUERIES.
	
	3	List the name, job, and department of employees who have the same job as Jones or a salary greater than or equal to Ford.

	4	Find all employees in department 10 that have a job that is the same as anyone in the Sales department

	5	Find the employees located in Liverpool who have the same job as Allen. Return the results in alphabetical order by employee name.

	 */
	 
	 
SELECT e.ename, e.job, d.dname FROM emp_1008610086 e, dept_1008610086 d 
	WHERE e.deptno = d.deptno 
		AND ename !='JONES' 
			AND ( e.job IN 
				(SELECT job FROM emp_1008610086 WHERE ename = 'JONES') OR e.sal >= 
					(SELECT sal FROM emp_1008610086 WHERE ename = 'FORD'))
		
		

SELECT * FROM emp_1008610086 e WHERE deptno = 10 AND job IN
	(SELECT job FROM emp_1008610086 WHERE deptno = 
		(SELECT deptno FROM dept_1008610086 WHERE dname = 'SALES'))
		
	
SELECT * FROM emp_1008610086 WHERE deptno = 
	(SELECT deptno FROM dept_1008610086 WHERE loc = 'LIVERPOOL' ) AND job = 
		(SELECT job FROM emp_1008610086 WHERE ename = 'ALLEN') ORDER BY ename
	
	 
/* 	 
	 EXERCISES	4

	7	Show details of employee hiredates and the date of their first payday. 
		(Paydays occur on the last Friday of each month) (plus their names)

	 
*/

-- TODO
SELECT ename, hiredate,
DECODE (SIGN (NEXT_DAY (LAST_DAY (hiredate) - 7, '星期五') - hiredate),
		    -1, NEXT_DAY (LAST_DAY (ADD_MONTHS (hiredate, 1)) - 7, '星期五'),
 		    NEXT_DAY (LAST_DAY (hiredate) - 7, '星期五'))
  	       AS payday
  FROM   emp_2015090170


/* 
	9	Create a view for use by personnel in department 30 showing employee 		
	name, number, job and hiredate

	10	Use the view to show employees in department 30 having jobs which 		
	are not salesman

	11	Create a view which shows summary information for each department.
 */


	
CREATE VIEW dept30_1008610086 (ename, empno, job, hiredate)
		AS SELECT ename, empno, job, hiredate FROM emp_1008610086
			WHERE deptno = 30;
			
			
SELECT * FROM dept_1008610086 WHERE job !='SALESMAN'


CREATE VIEW dept_summary_1008610086 (deptno,dname)
		AS SELECT deptno,dname FROM dept_1008610086
		



