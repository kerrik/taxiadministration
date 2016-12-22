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


$dbcreate[] = array('type'=>'TABLE', 'name'=>'Cab' , 'sql'=> <<<EOF
    CREATE TABLE Cab 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  cab CHAR(12) UNIQUE NOT NULL,
  pass INT
)
  ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO Cab (cab, pass) VALUES 
    ('820', 2),
    ('822', 2)
;
     
EOF
    ); //end $dbcreate



