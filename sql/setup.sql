USE todolist;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)


);

CREATE TABLE dolist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    notes VARCHAR(255),
    user_id INT NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(id)
);
