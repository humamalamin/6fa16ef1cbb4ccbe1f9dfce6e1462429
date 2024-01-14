CREATE DATABASE recipients;


CREATE TABLE recipients (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    subjects VARCHAR(255) NOT NULL,
    message text NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
