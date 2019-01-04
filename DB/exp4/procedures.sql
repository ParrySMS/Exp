
# 1.  Preparation (5 points)

CREATE TABLE db_employees (
	eid VARCHAR (3) NOT NULL,
	ename VARCHAR (15),
	city VARCHAR (15),
	PRIMARY KEY (eid)
);

CREATE TABLE db_customers (
	cid VARCHAR (4) NOT NULL,
	cname VARCHAR (15),
	city VARCHAR (15),
	visits_made INT (5),
	last_visit_time datetime,
	PRIMARY KEY (cid)
);

CREATE TABLE db_suppliers (
	sid VARCHAR (2) NOT NULL,
	sname VARCHAR (15) NOT NULL,
	city VARCHAR (15),
	telephone_no CHAR (11),
	PRIMARY KEY (sid),
	UNIQUE (sname)
);

CREATE TABLE db_products (
	pid VARCHAR (4) NOT NULL,
	pname VARCHAR (15) NOT NULL,
	qoh INT (5) NOT NULL,
	qoh_threshold INT (5),
	original_price DECIMAL (6, 2),
	discnt_rate DECIMAL (3, 2),
	sid VARCHAR (2),
	PRIMARY KEY (pid),
	FOREIGN KEY (sid) REFERENCES db_suppliers (sid)
);

CREATE TABLE db_purchases (
	pur VARCHAR (4) NOT NULL,
	cid VARCHAR (4) NOT NULL,
	eid VARCHAR (3) NOT NULL,
	pid VARCHAR (4) NOT NULL,
	qty INT (5),
	ptime datetime,
	total_price DECIMAL (7, 2),
	PRIMARY KEY (pur),
	FOREIGN KEY (cid) REFERENCES db_customers (cid),
	FOREIGN KEY (eid) REFERENCES db_employees (eid),
	FOREIGN KEY (pid) REFERENCES db_products (pid)
);

CREATE TABLE db_logs (
	logid INT (5) NOT NULL AUTO_INCREMENT,
	who VARCHAR (10) NOT NULL,
	time datetime NOT NULL,
	table_name VARCHAR (20) NOT NULL,
	operation VARCHAR (6) NOT NULL,
	key_value VARCHAR (4),
	PRIMARY KEY (logid)
);


# 2.  MySQL Implementation (50 points)

#(1)1.	(6 points) Write a stored procedure
# to show the tuples in each table.
# For example, you can implement a procedure,
# say show_products(), to display all products
# in the products table.

DROP PROCEDURE IF EXISTS show_cust;
DROP PROCEDURE IF EXISTS show_emp;
DROP PROCEDURE IF EXISTS show_logs;
DROP PROCEDURE IF EXISTS show_pro;
DROP PROCEDURE IF EXISTS show_prch;
DROP PROCEDURE IF EXISTS show_sup;

DELIMITER $$

CREATE PROCEDURE show_cust ()
  BEGIN
    SELECT * FROM db_customers;
  END $$

CREATE PROCEDURE show_emp ()
  BEGIN
    SELECT * FROM db_employees;
  END $$

CREATE PROCEDURE show_logs ()
  BEGIN
    SELECT * FROM db_logs;
  END $$

CREATE PROCEDURE show_pro ()
  BEGIN
    SELECT * FROM db_products;
  END $$

CREATE PROCEDURE show_prch ()
  BEGIN
    SELECT * FROM db_purchases;
  END $$

CREATE PROCEDURE show_sup ()
  BEGIN
    SELECT * FROM db_suppliers;
  END $$

DELIMITER ;

CALL show_cust();
CALL show_emp();
CALL show_logs();
CALL show_pro();
CALL show_prch();
CALL show_sup();

#(2)  2.	(4 points) Write a procedure to
# report the monthly sale information
# for any given product. For example,
#  you can use a procedure,
# say report_monthly_sale(prod_id), for this operation.
#  For the given product id, you need to report the product name,
#  the month (the first three letters of the month,
# e.g., FEB for February), year,
# the total quantity sold each month,
# the total dollar amount sold each month,
# and the average sale price
# (the total dollar amount divided by the total quantity) of each month.
# You need to list the information for only those months
# during which the given product has been purchased by some customers.

DROP PROCEDURE IF EXISTS mon2str;
DROP PROCEDURE IF EXISTS report_monthly_sale;
DELIMITER $$

CREATE PROCEDURE mon2str(IN num INT,OUT mon VARCHAR(5))
BEGIN
  CASE num
  WHEN 1 THEN SET mon = 'JAN';
  WHEN 2 THEN SET mon = 'FEB';
  WHEN 3 THEN SET mon = 'MAR';
  WHEN 4 THEN SET mon = 'APR';
  WHEN 5 THEN SET mon = 'MAY';
  WHEN 6 THEN SET mon = 'JUN';
  WHEN 7 THEN SET mon = 'JUL';
  WHEN 8 THEN SET mon = 'AUG';
  WHEN 9 THEN SET mon = 'SEP';
  WHEN 10 THEN SET mon = 'OCT';
  WHEN 11 THEN SET mon = 'NOV';
  WHEN 12 THEN SET mon = 'DEC';
  END CASE;

END $$


CREATE PROCEDURE report_monthly_sale(IN prod_id INT)
  BEGIN
    DECLARE proname VARCHAR(50);
    #   OUT month VARCHAR(5),
    DECLARE mon_total_qty INT;
    DECLARE mon_total_pri INT;
    DECLARE mon_avg_pri INT;
    DECLARE mon_num INT;
    DECLARE mon_str VARCHAR(5);

    SELECT pname INTO proname FROM db_products WHERE pid = prod_id;
    select MONTH(CURDATE()) INTO mon_num;
    CALL mon2str(mon_num,mon_str);
    SELECT SUM(qty) INTO mon_total_qty FROM db_purchases WHERE pid = prod_id;
    SELECT SUM(total_price) INTO mon_total_pri FROM db_purchases WHERE pid = prod_id;
    SET mon_avg_pri = mon_total_pri/mon_total_qty;
    SELECT proname,mon_str,mon_total_qty, mon_total_pri, mon_avg_pri;
  END $$
DELIMITER ;

CALL report_monthly_sale(1);

# 3 Write procedures to add tuples into the purchases table and the products table.
# As an example, you can use a procedure,
# say add_purchase(pur_no, c_id, e_id, p_id, pur_qty),
#  to add a tuple in the purchases table,
# where pur_no, c_id, e_id, p_id and pur_qty are parameters of the procedure.
#  Note that total_price should be computed based on the data in the database automatically
# and ptime should be the current time (use current_timestamp).
DELIMITER $$
CREATE PROCEDURE  add_purchase(IN pur_no INT ,IN c_id INT , IN e_id INT ,  IN p_id INT, IN pur_qty INT )
  BEGIN
    

  END $$
DELIMITER ;

/*

4.	(9 points) Add a tuple to the logs table automatically whenever any table is modified. To simplify, you are only required to consider the following modifications (events): (1) insert a tuple into the purchases table; (2) update the qoh attribute of the products table; and (3) update the visits_made attribute of the customers table. When a tuple is added to the logs table due to the first event, the table_name should be “purchases”, the operation should be “insert” and the key_value should be the pur of the newly inserted purchase. When a tuple is added to the logs table due to the second event, the table_name should be “products”, the operation should be “update” and the key_value should be the pid of the affected product. When a tuple is added to the logs table due to the third event, the table_name should be “customers”, the operation should be “update” and the key_value should be the cid of the affected customer. Adding tuples to the logs table should be implemented using triggers. You need to implement three triggers for this task, one for each event.


5.	(4 points) Before a purchase is actually made (i.e., before a tuple is added into the purchases table), your program needs to make sure that, for the involved product, the quantity to be purchased is equal to or smaller than the quantity on hand (qoh). Otherwise, an appropriate message should be displayed (e.g., “Insufficient quantity in stock.”) and the purchase request should be rejected.

6.	(16 points) After adding a tuple to the purchases table, the qoh column of the products table should be modified accordingly; that is, the qoh of the product involved in the purchase should be reduced by the quantity purchased. If the purchase causes the qoh of the product to be below qoh_threshold, your program should perform the following tasks: (1) print a message indicating the current qoh of the product, (b) increase qoh by making it 2 * old_qoh, where old_qoh represents the value of qoh before the corresponding purchase was made (other attribute values of the product will not be changed), and (c) print another message indicating that the quantity on hand of the product has been increased by old_qoh + qty_sold, where qty_sold is the number of the product sold in the involved purchase. In addition, the insertion of the new tuple in the purchases table will cause the visits_made of the customer to be increased by one. Use triggers to implement the update of qoh, printing of the messages and the update of visits_made and last_visit_time.

7.	(4 points) You need to make your code user friendly by designing and displaying appropriate messages for all exceptions. For example, if someone wants to find the purchases of a customer but entered a non-existent customer id, your program should report the problem clearly.
*/