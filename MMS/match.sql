
DROP TABLE IF EXISTS Matches;

CREATE TABLE Matches(
	MatchId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Matchdate DATE NOT NULL,
	Starttime time NOT NULL,
	Duration INT NOT NULL, 
	Location varchar(100) NOT NULL,
	Capacity INT(100) NOT NULL,
	Spaces INT(100) NOT NULL,
	Information varchar(255)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Matches;

CREATE TABLE Usermatch(
	Username varchar(40) NOT NULL,
	CONSTRAINT en_username
	FOREIGN KEY(Username)
	REFERENCES Player (Username),

	MatchId INT NOT NULL,
	CONSTRAINT en_matchid
	FOREIGN KEY(MatchId)
	REFERENCES Matches(MatchId)
)ENGINE=InnoDB;
