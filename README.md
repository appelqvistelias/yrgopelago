# Yrgopelago

This is a school project with the purpose of creating a hotel website with a booking system, using HTML, CSS, PHP, JavaScript, and SQL. The project also incorporates the use of an API.

Based on the assignment requirements, the site is optimized for desktop use only, and the booking system is restricted to January 2025. However, this limitation can easily be adjusted in the code.

The project also makes use of Composer.

## Database structure:

Since the database is not included in the repository, you will need to create one yourself using the queries provided below. Place the database in a subfolder named 'database' within the project's root directory.

```sql
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

## Student to student feedback

1. Your index.php is well-structured into three parts: header.php, index.php, and footer.php, which greatly enhances readability.

2. booking.php:13-20 - The keys you’re using have inconsistent naming conventions. Some use camelCase, others use hyphens (-), and some have no specific case pattern.

3. Nice organization of the different files, each with its specific functionality. However, to improve the directory structure, you could place them in separate folders, making it easier to locate and manage these files.

4. booking.php:62-80 - The code contains repetitive if-else logic and nested loops. Instead, you could simplify this by using an array to map rooms to their prices and reduce it to just two if-else statements for better readability and maintainability.

5. header.php:8-11 - You’ve organized your styles into separate stylesheets, which is great for maintaining structure. However, instead of linking each stylesheet individually, you could consolidate them into a single main.css file using @import(url) and link just that one stylesheet for better efficiency.

6. I appreciate that you use global variables for your styles, as it makes it easier to maintain consistency and reuse the same variables without confusion.

7. A better README file should include: the project title, a more detailed description of how the site functions from a user perspective, installation instructions (not just database setup), usage instructions for the site, and information about the license.