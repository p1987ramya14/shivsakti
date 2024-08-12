<?php
// Define your API key from IPinfo
$api_key = '74d82695097c9ae636753594abe9b543'; // Replace with your actual IPinfo API key

// Define URLs for redirection
$residence_url = 'https://roastandrelish.store';
$amazon_url = 'https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF';

// Function to get user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Get user IP address
$user_ip = getUserIP();

// Use IPinfo API to get location data
$ipinfo_url = "http://ipinfo.io/{$user_ip}/json?token={$api_key}";
$response = @file_get_contents($ipinfo_url);

// Handle API request failure
if ($response === FALSE) {
    header("Location: $amazon_url", true, 302);
    exit();
}

$ipinfo = json_decode($response, true);

// Handle JSON parsing error
if (json_last_error() !== JSON_ERROR_NONE) {
    header("Location: $amazon_url", true, 302);
    exit();
}

// Redirect based on country
if (isset($ipinfo['country']) && $ipinfo['country'] === 'US') {
    header("Location: $residence_url", true, 302);
} else {
    header("Location: $amazon_url", true, 302);
}

exit();
?>
