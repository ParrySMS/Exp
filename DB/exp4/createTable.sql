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

