<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';  // Make sure you've installed the Google Client Library using Composer

// Initialize Google Client
$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT']); // The URL Google will redirect to after successful login

if (isset($_GET['code'])) {
    // The user authorized the app and we got the code
    // Use the code to get the access token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Store the access token in the session
    $_SESSION['access_token'] = $token;

    // Set the client access token
    $client->setAccessToken($token);

    // Now you can get the user’s information
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get(); // This will fetch the user's profile information

    // You can now store the user's information in the session or a database
    $_SESSION['user_info'] = [
        'id' => $userInfo->id,
        'name' => $userInfo->name,
        'email' => $userInfo->email,
        'picture' => $userInfo->picture
    ];

    // Redirect the user to your app's home page or dashboard after successful authentication
    header('Location: dashboard.php');  // Or wherever you want to redirect after login
    exit();
} else {
    // If there's no code (e.g., user denies permission), handle accordingly
    echo "Google OAuth Error: No authorization code received.";
}
?>

