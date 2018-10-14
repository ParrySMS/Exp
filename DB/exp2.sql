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
	
	
	
	