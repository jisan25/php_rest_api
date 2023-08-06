<?php

// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & Connect

$database = new Database();
$db = $database->connect();

// Instantiate blog post object

$category = new Category($db);

// category Query

$result = $category->read();

// Get Row Count

$num = $result->rowCount();

// Check if any posts

if ($num > 0) {
    // Post Array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'name' => $name,
        );
        //  Push to 'data'
        array_push($posts_arr['data'], $post_item);
    }
    // Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}
