CREATE DATABASE IF NOT EXISTS busara;
USE busara;

CREATE TABLE IF NOT EXISTS survey (
  id INT NOT NULL PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  cellphone VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS demographic (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL UNIQUE,
  description VARCHAR(1024) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS demographic_values (
  survey_id INT NOT NULL,
  demographic_id INT NOT NULL,
  value VARCHAR(255) NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (survey_id) REFERENCES survey(id),
  FOREIGN KEY (demographic_id) REFERENCES demographic(id)
);

CREATE TABLE IF NOT EXISTS project (
  id INT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  notes BLOB
);

CREATE TABLE IF NOT EXISTS session (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  project_id INT NOT NULL,
  timestamp DATETIME NOT NULL,
  notes BLOB,
  FOREIGN KEY (project_id) REFERENCES project(id)
);

CREATE TABLE IF NOT EXISTS participation (
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

#sample data
#INSERT INTO survey (id, first_name, last_name, cellphone) VALUES 
#  (123456, "Sudarshan", "Muralidhar", "4047974044"), 
#  (234567, "Joe", "Schmoe", "1234567890");
#INSERT INTO demographic (name) VALUES
#  ("cellphone2"), ("address");
#INSERT INTO demographic_values (survey_id, demographic_id, value) VALUES 
#  (123456, 1, "4049978370"),
#  (123456, 2, "3909 Spruce Street"),
#  (234567, 2, "1234 South Avenue");
#INSERT INTO project (id, name) VALUES (12345, "Test Project 1"), (23456, "Test Project 2");
#INSERT INTO session(id, project_id, timestamp) VALUES 
#  (1, 12345, "2014-9-14 18:00"), (2, 12345, "2014-9-17 8:00"), (3, 23456, "2014-9-14 18:00");
#INSERT INTO participation (survey_id, session_id, invited) VALUES (123456, 1, 1);
