This is a school project with the purpose to create a hotel with a booking system using HTML, CSS, PHP and JavaScript. The project will also include the usage of API.

Database structure:
```
CREATE TABLE IF NOT EXISTS room_types (
id INTEGER PRIMARY KEY AUTOINCREMENT,
type VARCHAR(255),
price INTEGER);

INSERT INTO room_types (type, price)
VALUES ("Economy", 1),
("Standard", 2),
("Luxury", 4);


CREATE TABLE IF NOT EXISTS features (
id INTEGER PRIMARY KEY AUTOINCREMENT,
name VARCHAR(255) NOT NULL,
price INTEGER NOT NULL);

INSERT INTO features (name, price)
VALUES ("Bathtub", 1),
("Pinball-Game", 2),
("Sauna", 3);


CREATE TABLE IF NOT EXISTS bookings (
id INTEGER PRIMARY KEY AUTOINCREMENT,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
start_date DATE NOT NULL,
end_date DATE NOT NULL,
room_type_id INTEGER NOT NULL,
total_cost INTEGER NOT NULL,
transfer_code TEXT NOT NULL,

FOREIGN KEY (room_type_id) REFERENCES room_types(id)
);


CREATE TABLE IF NOT EXISTS booking_features (
booking_id INTEGER NOT NULL,
feature_id INTEGER NOT NULL,
PRIMARY KEY (booking_id, feature_id),

FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
FOREIGN KEY (feature_id) REFERENCES features(id) ON DELETE CASCADE
);
```