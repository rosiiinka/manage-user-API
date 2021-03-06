<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && $data->id > 0 && !empty($data->email) && !empty($data->firstName) && !empty($data->lastName)) {
    $user->id = $data->id;
    $user->email = $data->email;
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;

    if ($user->update()) {

        http_response_code(200);

        echo json_encode(array("message" => "User was updated successfully."));
    } else {

        http_response_code(503);

        echo json_encode(array("message" => "Unable to update user."));
    }
}else{

    http_response_code(400);

    echo json_encode(array("message" => "Unable to update user. Data is incomplete."));
}