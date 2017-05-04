use db_zy18745;

DROP TABLE IF EXISTS player;

CREATE TABLE Player(
    Username varchar(40) PRIMARY KEY,
    Name varchar(60) NOT NULL,
    Email varchar(100) NOT NULL,
    Phone varchar(50) NOT NULL,
    Password varchar(255) NOT NULL,
    Type varchar(6) default "Player"
)ENGINE=InnoDB;
