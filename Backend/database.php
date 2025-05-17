<?php
session_start();

include_once 'Backend/imports.php';
include_once 'Backend/web.php';

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mydatabase');

function try_connect_to_database(): void
{
    global $database_link;

    if (isset($database_link)) {
        return;
    }

    $database_link = mysqli_connect(hostname: DB_SERVER, username: DB_USERNAME, password: DB_PASSWORD, database: DB_NAME);

    if ($database_link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
}

function get_all_users(): array
{
    global $database_link;

    $query = "SELECT * FROM users";
    $result = mysqli_query(mysql: $database_link, query: $query);

    if ($result) {
        return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function get_user_by_username(string $username): ?array
{
    global $database_link;

    $query = "SELECT * FROM Users WHERE Username = ?";

    $statement = mysqli_prepare($database_link, $query);
    if (!$statement) {
        return null;
    }
    mysqli_stmt_bind_param($statement, 's', $username);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        return $user;
    } else {
        return null;
    }
}

function register_user($username, $password)
{
    global $database_link;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $statement = mysqli_prepare($database_link, $query);
    mysqli_stmt_bind_param($statement, 'ss', $username, $hashed_password);

    if (mysqli_stmt_execute($statement)) {
        return true;
    } else {
        return "Error: " . mysqli_error($database_link);
    }
}

function try_login_user($username, $password): bool
{
    global $database_link;

    $user = get_user_by_username(username: $username);

    if ($user && isset($user['Password']) && $user['Password'] !== null) {
        if (password_verify(password: $password, hash: $user['Password'])) {
            $_SESSION['User'] = $user;
            return true;
        } else {
            return false;
        }
    }

    return false;
}

function redirect_to_login(): void
{
    if (isset($_SESSION['User'])) {
        return;
    }

    if (current_page() === 'login.php') {
        return;
    }

    if (current_page() === 'register.php') {
        return;
    }

    if (current_page() === 'database.php') {
        return;
    }

    header('Location: login.php');
    exit();
}

function get_activities_from_user($user): array
{
    global $database_link;

    $query = "SELECT * FROM activities WHERE UserId = ?";
    $statement = mysqli_prepare($database_link, $query);
    mysqli_stmt_bind_param($statement, 'i', $user['UserId']);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

try_connect_to_database();
redirect_to_login();

?>