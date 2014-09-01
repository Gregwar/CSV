<?php

include(__DIR__.'/../CSVFile.php');

// Creates a loader and define the columns
$loader = new Gregwar\CSV\CSVFile;
$loader->setColumns(array('lastname', 'firstname'));

// Some data
$data = array(
    array('firstname' => 'Bob', 'lastname' => 'Smith', 'age' => 30),
    array('lastname' => 'Taylor', 'firstname' => 'William', 'age' => 40),
);

// Save the data to data.csv, using the above columns, note that age will
// be lost
$loader->save('data.csv', $data);

// Loads the data back using the same columns matching
$data = $loader->load('data.csv');
var_dump($data);
