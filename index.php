<?php
// Define your API key from IPinfo
$api_key = '74d82695097c9ae636753594abe9b543'; // Replace with your actual IPinfo API key

// Define the URLs for redirection
$residence_url = 'https://roastandrelish.store';
$amazon_url = 'https://www.amazon.com/Simple-Joys-Carters-Short-Sleeve-Bodysuit/dp/B07GY1RRZF';

// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Check if IP is passed from shared internet
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check if IP is passed from proxy
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Get IP address
        return $_SERVER['REMOTE_ADDR'];
    }
}

$user_ip = getUserIP();

// Use IPinfo API to get location data
$ipinfo_url = "http://ipinfo.io/{$user_ip}/json?token={$api_key}";
$response = @file_get_contents($ipinfo_url);

// Error handling for API request
if ($response === FALSE) {
    // If API request fails, redirect to the default URL
    header("Location: $amazon_url");
    exit();
}

$ipinfo = json_decode($response, true);

// Error handling for JSON parsing
if (json_last_error() !== JSON_ERROR_NONE) {
    // If JSON parsing fails, redirect to the default URL
    header("Location: $amazon_url");
    exit();
}

// Check if the country is US (or any other country you need)
if (isset($ipinfo['country']) && $ipinfo['country'] === 'US') {
    header("Location: $residence_url");
} else {
    header("Location: $amazon_url");
}

// Ensure no further code is executed after redirection
exit();
?>
