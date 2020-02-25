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
        DeviceName Varchar (15) NOT NULL ,
        RoomNumber Int NOT NULL
	,CONSTRAINT Device_PK PRIMARY KEY (DeviceId)

	,CONSTRAINT Device_Room_FK FOREIGN KEY (RoomNumber) REFERENCES Room(RoomNumber)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Message
#------------------------------------------------------------

CREATE TABLE Message(
        MessageId          Int  Auto_increment  NOT NULL ,
        MessageTemperature Varchar (254) NOT NULL ,
        MessageHumidity    Varchar (254) NOT NULL ,
        MessageTime        Varchar (254) NOT NULL ,
        DeviceId           Int NOT NULL
	,CONSTRAINT Message_PK PRIMARY KEY (MessageId)

	,CONSTRAINT Message_Device_FK FOREIGN KEY (DeviceId) REFERENCES Device(DeviceId)
)ENGINE=InnoDB;

