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
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO User (acronym, name, salt) VALUES 
    ('doe', 'John/Jane Doe', unix_timestamp()),
    ('admin', 'Administrator', unix_timestamp())
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
(1, 2, 'TFL'),
(2, 1, 'Tel'),
(3, 3, 'Mobil'),
(4, 4, 'Adress');
     
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
    ('1', 1, '1234567');
     
EOF
    ); //end $dbcreate



