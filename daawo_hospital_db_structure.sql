
CREATE DATABASE IF NOT EXISTS daawo_hospital_db;
USE daawo_hospital_db;

CREATE TABLE admins (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
);

CREATE TABLE departments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    department_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE patients (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
);

CREATE TABLE doctors (
    id INT(11) NOT NULL AUTO_INCREMENT,
    department_id INT(11) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    daily_capacity INT(11) NOT NULL DEFAULT 200,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email),
    KEY department_id (department_id),
    CONSTRAINT fk_doctor_department
      FOREIGN KEY (department_id) REFERENCES departments(id)
      ON UPDATE CASCADE
);

CREATE TABLE tickets (
    id INT(11) NOT NULL AUTO_INCREMENT,
    patient_id INT(11) NOT NULL,
    doctor_id INT(11) DEFAULT NULL,
    department_id INT(11) NOT NULL,
    ticket_number VARCHAR(20) NOT NULL,
    booking_date DATE NOT NULL,
    queue_position INT(11) NOT NULL,
    status ENUM('Waiting','Serving','Completed') NOT NULL DEFAULT 'Waiting',
    is_emergency TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY patient_id (patient_id),
    KEY doctor_id (doctor_id),
    KEY department_id (department_id),
    CONSTRAINT fk_ticket_patient
      FOREIGN KEY (patient_id) REFERENCES patients(id)
      ON UPDATE CASCADE,
    CONSTRAINT fk_ticket_doctor
      FOREIGN KEY (doctor_id) REFERENCES doctors(id)
      ON UPDATE CASCADE,
    CONSTRAINT fk_ticket_department
      FOREIGN KEY (department_id) REFERENCES departments(id)
      ON UPDATE CASCADE
);

CREATE TABLE notifications (
    id INT(11) NOT NULL AUTO_INCREMENT,
    patient_id INT(11) NOT NULL,
    ticket_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    notification_type VARCHAR(50) NOT NULL,
    is_sent TINYINT(1) NOT NULL DEFAULT 0,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY patient_id (patient_id),
    KEY ticket_id (ticket_id),
    CONSTRAINT fk_notification_patient
      FOREIGN KEY (patient_id) REFERENCES patients(id)
      ON UPDATE CASCADE,
    CONSTRAINT fk_notification_ticket
      FOREIGN KEY (ticket_id) REFERENCES tickets(id)
      ON UPDATE CASCADE
);

INSERT INTO departments (department_name) VALUES
('General Medicine'),
('Dental Clinic'),
("Children''s Clinic"),
('Emergency');
