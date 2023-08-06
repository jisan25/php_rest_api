<?php

// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & Connect

$database = new Database();
$db = $database->connect();

// Instantiate Category Object

$category = new Category($db);

// GET ID

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Post

$category->read_single();

$post_arr = array(
    'id' => $category->id,
    'name' => $category->name
);

print_r(json_encode($post_arr));
