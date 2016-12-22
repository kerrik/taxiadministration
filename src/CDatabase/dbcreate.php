<?php
$db_prefix = "";
$db_new_db = false;
$dbcreate = array();

/* Mall för skapandet av tabeller
$dbcreate[] = array('type'=>'TABLE', 'name'=>'' , 'sql'=> <<<EOF
EOF
    , 'data'=> <<<EOF
EOF
    ); //end $dbcreate
 */


$dbcreate[] = array('type'=>'TABLE', 'name'=>'User' , 'sql'=> <<<EOF
    CREATE TABLE User 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  acronym CHAR(12) UNIQUE NOT NULL,
  name VARCHAR(80),
  password CHAR(32),
  role INT,
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO User (acronym, name, role, salt) VALUES 
    ('doe', 'John/Jane Doe', 10, unix_timestamp()),
    ('admin', 'Administrator', 1, unix_timestamp())
;
UPDATE User SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';
UPDATE User SET password = md5(concat('admin', salt)) WHERE acronym = 'admin';
     
EOF
    ); //end $dbcreate

$dbcreate[] = array('type'=>'TABLE', 'name'=>'system' , 'sql'=> <<<EOF
    CREATE TABLE system 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name char(8),
  value char(10)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO system (name, value) VALUES 
    ('dB_Ver',  '1');
     
EOF
    ); //end $dbcreate
$dbcreate[] = array('type'=>'TABLE', 'name'=>'user_data_key' , 'sql'=> <<<EOF
    CREATE TABLE user_data_key
(
  user_data_id INT NOT NULL PRIMARY KEY,
  user_data_sort INT,
  user_data_descr CHAR(10)  
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO user_data_key (user_data_id, user_data_sort, user_data_descr)
VALUES
(1, 4, 'TFL'),
(2, 1, 'Tel'),
(3, 3, 'Mobil'),
(4, 3, 'Adress');
     
EOF
    ); //end $dbcreate
$dbcreate[] = array('type'=>'TABLE', 'name'=>'user_data' , 'sql'=> <<<EOF
    CREATE TABLE user_data 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user int,
  user_data_id int,
  value char(100),
  value_dec DECIMAL(10,2)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO user_data (user, user_data_id, value) VALUES 
    ('1', 1, '9876543'),        
    ('1', 2, '060 336 678'),        
    ('1', 3, '076 578 945'),        
    ('1', 4, 'Hemgatan 6'),
    ('2', 1, '1234567'),        
    ('2', 2, '08 30 20 40'),        
    ('2', 3, '070 256 235'),        
    ('2', 4, 'Stortorget 4 ');
     
EOF
    ); //end $dbcreate

$dbcreate[] = array('type'=>'TABLE', 'name'=>'data_key' , 'sql'=> <<<EOF
    CREATE TABLE data_key
(
  data_id INT AUTO_INCREMENT PRIMARY KEY,
  data_parent INT NOT NULL,
  data_key INT NOT NULL,
  data_sort INT,
  data_descr CHAR(10)  
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO data_key (data_parent, data_key, data_sort, data_descr)
VALUES
(1, 1, 4, 'TFL'),
(1, 2, 1, 'Tel'),
(1, 3, 3, 'Mobil'),
(1, 4, 3, 'Adress'),
(2, 5, 1, 'Tel'),
(2, 6, 2, 'Regnr'),
(2, 7, 3, 'Typ'),
(2, 8, 4, 'Försäkring');
     
EOF
    ); //end $dbcreate


$dbcreate[] = array('type'=>'TABLE', 'name'=>'data_value' , 'sql'=> <<<EOF
    CREATE TABLE data_value
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent int,
  data_id int,
  value char(100),
  value_dec DECIMAL(10,2)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO data_value (parent, data_id, value) VALUES 
    ('1', 1, '9876543'),        
    ('1', 2, '060 336 678'),        
    ('1', 3, '076 578 945'),        
    ('1', 4, 'Hemgatan 6'),
    ('2', 1, '1234567'),        
    ('2', 2, '08 30 20 40'),        
    ('2', 3, '070 256 235'),        
    ('2', 4, 'Stortorget 4 '),    
    ('1', 1, '070150820'),        
    ('1', 2, 'KSM780'),        
    ('1', 3, 'Volvo V70'),        
    ('1', 4, 'Norska Brand'),
    ('2', 1, '07150822'),        
    ('2', 2, 'XXX999'),        
    ('2', 3, 'MB 300E'),        
    ('2', 4, 'Norska Brand');
     
EOF
    ); //end $dbcreate



