CREATE SCHEMA IF NOT EXISTS aslan;

/**
 * Users of Aslan.
 */
CREATE TABLE IF NOT EXISTS aslan.Users  (
	email VARCHAR(64) UNIQUE NOT NULL,
	password VARCHAR(64) NOT NULL,
	authToken VARCHAR(64) UNIQUE DEFAULT NULL,
	name VARCHAR(32) NOT NULL,
	surname VARCHAR(32) NOT NULL,
	CONSTRAINT PK_Users PRIMARY KEY (email)
);

/**
 * List of devices handled by the system.
 */
CREATE TABLE IF NOT EXISTS aslan.DeviceTypes (
	name VARCHAR(16) PRIMARY KEY
);

/**
 * Registered devices owned by users.
 */
CREATE TABLE IF NOT EXISTS aslan.Devices (
	user VARCHAR(64) NOT NULL,
	hostName VARCHAR(32) NOT NULL,
	name VARCHAR(16) NOT NULL,
	type VARCHAR(16) NOT NULL,
	listeningPort SMALLINT NOT NULL,
	CONSTRAINT PK_Devices PRIMARY KEY (user, hostName, name),
	CONSTRAINT UC_Devices_IP_PORT UNIQUE (hostName, listeningPort),
	CONSTRAINT FK_Devices_Type FOREIGN KEY (type) REFERENCES DeviceTypes(name) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT FK_Devices_User FOREIGN KEY (user) REFERENCES Users(email)
);
