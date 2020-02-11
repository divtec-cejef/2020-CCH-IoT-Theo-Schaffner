CREATE TABLE Salle
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    NomSalle varchar(5) not null
);

CREATE TABLE Device
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    NomDevice varchar(10) not null UNIQUE,
	id_Salle int(11) not null,
    FOREIGN KEY (id_Salle) REFERENCES Salle(id)
);

CREATE TABLE Messages
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Temperature varchar(254) not null,
    Humidite varchar(254) not null,
    DateHeure varchar(254) not null,
	id_Device int(11) not null,
    FOREIGN KEY (id_Device) REFERENCES Device(id)
);
