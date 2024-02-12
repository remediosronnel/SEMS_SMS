<?php
session_start();
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that the necessary data is received through POST
    if (isset($_POST['apiKey']) && isset($_POST['number']) && isset($_POST['message']) && isset($_POST['sendername'])) {
        // Replace 'YOUR_SEMAPHORE_API_KEY' with your actual Semaphore API key
        
        $apiKey = $_POST['apiKey'];
        $phoneNumber = $_POST['number']; // Include country code
        $message = $_POST['message'];
        $sendername = $_POST['sendername'];
        
        
        // Create an array with the message details
        $data = [
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sender_name' => $sendername // corrected key name
        ];
        
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session
        $response = curl_exec($ch);
        var_dump($response);

        // Check for errors
        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // Handle the response
            $responseData = json_decode($response, true);
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                echo 'Message sent successfully!';
            } else {
                echo 'Failed to send message: ' . ($responseData['error'] ?? 'Unknown error');
            }
        }

        // Close cURL session
        curl_close($ch);
    } else {
        echo 'Incomplete data received.';
    }
} else {
    echo 'Invalid request method.';
}
?>
