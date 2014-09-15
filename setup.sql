DROP DATABASE IF EXISTS busara;
CREATE DATABASE busara;
USE busara;

# this is required information

CREATE TABLE survey (
  id INT NOT NULL PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  cellphone VARCHAR(255) NOT NULL
);

#Testdata
INSERT INTO survey (id, first_name, last_name, cellphone) VALUES 
  (123456, "Sudarshan", "Muralidhar", "4047974044"), 
  (234567, "Joe", "Schmoe", "1234567890");

CREATE TABLE demographic (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description VARCHAR(1024) DEFAULT NULL
);

# this is optional info
INSERT INTO demographic (name) VALUES
  ("cellphone2"), ("address");

CREATE TABLE demographic_values (
  survey_id INT NOT NULL,
  demographic_id INT NOT NULL,
  value VARCHAR(255) NOT NULL,
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (survey_id) REFERENCES survey(id),
  FOREIGN KEY (demographic_id) REFERENCES demographic(id)
);

#Testdata
INSERT INTO demographic_values (survey_id, demographic_id, value) VALUES 
  (123456, 1, "4049978370"),
  (123456, 2, "3909 Spruce Street"),
  (234567, 2, "1234 South Avenue");

CREATE TABLE project (
  id INT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  notes BLOB
);

#Testdata
INSERT INTO project (id, name) VALUES (12345, "Test Project 1"), (23456, "Test Project 2");

CREATE TABLE session (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  project_id INT NOT NULL,
  timestamp DATETIME NOT NULL,
  notes BLOB,
  FOREIGN KEY (project_id) REFERENCES project(id)
);

#Testdata
INSERT INTO session(id, project_id, timestamp) VALUES 
  (1, 12345, "2014-9-14 18:00"), (2, 12345, "2014-9-17 8:00"), (3, 23456, "2014-9-14 18:00");

CREATE TABLE participation (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  survey_id INT NOT NULL,
  session_id INT NOT NULL,
  invited BIT NOT NULL DEFAULT 0,
  identified BIT NOT NULL DEFAULT 0,
  participated BIT NOT NULL DEFAULT 0,
  pay DECIMAL (10,2),
  notes BLOB,
  FOREIGN KEY (survey_id) REFERENCES survey(id),
  FOREIGN KEY (session_id) REFERENCES session(id)
);

#Testdata
INSERT INTO participation (survey_id, session_id) VALUES (123456, 1);