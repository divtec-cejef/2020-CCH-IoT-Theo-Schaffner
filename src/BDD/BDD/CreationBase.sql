#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Room
#------------------------------------------------------------

CREATE TABLE Room(
        RoomNumber Int  Auto_increment  NOT NULL ,
        RoomName   Varchar (5) NOT NULL
	,CONSTRAINT Room_PK PRIMARY KEY (RoomNumber)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Device
#------------------------------------------------------------

CREATE TABLE Device(
        DeviceId   Int  Auto_increment  NOT NULL ,
        DeviceName Varchar (15) NOT NULL UNIQUE ,
        RoomNumber Int NOT NULL
	,CONSTRAINT Device_PK PRIMARY KEY (DeviceId)

	,CONSTRAINT Device_Room_FK FOREIGN KEY (RoomNumber) REFERENCES Room(RoomNumber)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Measure
#------------------------------------------------------------

CREATE TABLE Measure(
        MeasureId          Int  Auto_increment  NOT NULL ,
        MeasureTemperature Varchar (254) NOT NULL ,
        MeasureHumidity    Varchar (254) NOT NULL ,
        MeasureTime        Datetime (254) NOT NULL,
        DeviceId           Int NOT NULL
	,CONSTRAINT Measure_PK PRIMARY KEY (MeasureId)

	,CONSTRAINT Measure_Device_FK FOREIGN KEY (DeviceId) REFERENCES Device(DeviceId)
)ENGINE=InnoDB;

