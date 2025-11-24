DROP TABLE IF EXISTS A;
DROP TABLE IF EXISTS B;

CREATE TABLE A(
idA int PRIMARY KEY AUTO_INCREMENT,
colA varchar(50),
colB varchar(50)
);

CREATE TABLE B(
idB int PRIMARY KEY AUTO_INCREMENT,
colA varchar(50),
colB varchar(50),
idA int
);


insert into A (colA, colB) values ('Accounting','New York');

insert into A (colA, colB) values ('Research','Dallas');

insert into A (colA, colB) values ('Sales','Chicago');

insert into A (colA, colB) values ('Operations','Boston');

insert into B (colA, colB, idA) values ('John','CLERK',4);

insert into B (colA, colB, idA)values ('Matthew','SALESMAN',5);

insert into B (colA, colB, idA) values ('David','SALESMAN',3);

insert into B (colA, colB, idA) values ('Joanne','MANAGER',6);

insert into B (colA, colB, idA) values ('Victoria','MANAGER',1);

insert into B (colA, colB, idA) values ('John','MANAGER',4);

insert into B (colA, colB, idA) values ('David','ANALYST',2);

insert into B (colA, colB, idA) values ('Bob','PRESIDENT',3);

insert into B (colA, colB, idA) values ('Erick','SALESMAN',6);


-- LEFT JOIN
select * from A left join B on A.idA = B.idA;

-- RIGHT JOIN
select * from A right join B on A.idA = B.idA;

-- LEFT JOIN Exclusif
select * from A left join B on A.idA = B.idA where B.idA is NULL;

-- RIGHT JOIN Exclusif
select * from A right join B on A.idA = B.idA where A.idA is NULL;

-- INNER JOIN
select * from A inner join B on A.idA = B.idA;

-- FULL OUTER JOIN
select * from A left join B on A.idA = B.idA union select * from A right join B on A.idA = B.idA;

-- FULL OUTER JOIN Exclusif
select * from A left join B on A.idA = B.idA where B.idA is NULL union select * from A right join B on A.idA = B.idA where A.idA is NULL;
