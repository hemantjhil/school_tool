<?php
// Set the path to your audio file
$audioFilePath = '/period/01.mp3';

// Define the scheduled times in 24-hour format (HH:MM)
$scheduledTimes = ['08:50', '12:30', '17:15'];

// Get the current time
$current_time = date('H:i');

// Check if the current time matches any scheduled time
if (in_array($current_time, $scheduledTimes)) {
    // Command to play audio using mpg321
    $command = "mpg321 {$audioFilePath}";

    // Execute the command
    exec($command);

    // Output for testing purposes
    echo "Audio played at {$current_time}\n";
} else {
    // Output for testing purposes
    echo "No scheduled playtime at {$current_time}\n";
}
?>
