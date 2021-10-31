<?php

include('includes/config.php');

// Anslutning till databas
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno > 0) {
    die("Fel vid anslutning: " . $db->connect_error);
}
// Skapa/Återställ databaser
$sql = "DROP TABLE IF EXISTS sites;";
$sql .= "DROP TABLE IF EXISTS studies;";
$sql .= "DROP TABLE IF EXISTS jobs;";
$sql .= "
CREATE TABLE studies(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    uni VARCHAR(128) NOT NULL,
    edu VARCHAR(128) NOT NULL,
    start DATE NOT NULL,
    end DATE NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";
$sql .= "
CREATE TABLE jobs(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    job VARCHAR(128) NOT NULL,
    title VARCHAR(128) NOT NULL,
    start DATE NOT NULL,
    end DATE NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";
$sql .= "
CREATE TABLE sites(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    url VARCHAR(128) NOT NULL,
    info VARCHAR(256) NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";


$sql .= "
    INSERT INTO studies(uni, edu, start, end) VALUES ('Hamreskolan', 'Mellanstadiet', '1994-10-10', '2002-04-10');
";
$sql .= "
    INSERT INTO jobs(job, title, start, end) VALUES ('Aroslunds Livs', 'Butiksbiträde', '2007-02-10', '2012-04-10');
";
$sql .= "
    INSERT INTO sites(title, url, info) VALUES ('Projektsida', 'www.google.com', 'Min hemsida för projektet i föregående kurs');
";

echo "<pre>$sql</pre>";

// Kontroll på installation
if ($db->multi_query($sql)) {
    echo "<p>Korrekt uppladdning!</p>";
} else {
    echo "<p>Fel vid uppladdning</p>";
}