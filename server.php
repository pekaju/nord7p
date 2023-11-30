<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
    exit;
}else {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
}
$logFilePath = 'phperr.log';

// Connect to SQLite database
$databaseFile = 'database.sqlite';
$pdo = new PDO("sqlite:$databaseFile");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec('CREATE TABLE IF NOT EXISTS CUSTOMER (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    FirstName TEXT,
    LastName TEXT,
    DateOfBirth TEXT,
    Username TEXT,
    Password TEXT
)');

// Handle HTTP requests
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
    case 'POST':
        handlePostRequest();
        break;
    case 'PUT':
        handlePutRequest();
        break;
    case 'DELETE':
        handleDeleteRequest();
        break;
    default:
        http_response_code(405); // Method Not Allowed
        break;
}

function handleGetRequest()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM CUSTOMER");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

function handlePostRequest()
{
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("INSERT INTO CUSTOMER (FirstName, LastName, DateOfBirth, Username, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data['FirstName'], $data['LastName'], $data['DateOfBirth'], $data['Username'], $data['Password']]);

    echo json_encode(['message' => 'Customer added successfully']);
}

function handlePutRequest()
{
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE CUSTOMER SET FirstName=?, LastName=?, DateOfBirth=?, Username=?, Password=? WHERE ID=?");
    $stmt->execute([$data['FirstName'], $data['LastName'], $data['DateOfBirth'], $data['Username'], $data['Password'], $data['ID']]);

    echo json_encode(['message' => 'Customer updated successfully']);
}

function handleDeleteRequest()
{
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("DELETE FROM CUSTOMER WHERE ID=?");
    $stmt->execute([$data['ID']]);

    echo json_encode(['message' => 'Customer deleted successfully']);
}
?>