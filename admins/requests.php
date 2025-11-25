<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'receiver') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['request_donation'])) {
    $donation_id = $_POST['donation_id'];
    $receiver_id = $_SESSION['user_id'];

    // Check if already requested
    $check = $conn->query("SELECT * FROM requests WHERE donation_id='$donation_id' AND receiver_id='$receiver_id'");
    if ($check->num_rows > 0) {
        $_SESSION['message'] = "⚠️ You’ve already requested this donation!";
    } else {
        // Insert request (removed created_at to match your DB columns)
        $conn->query("INSERT INTO requests (donation_id, receiver_id, status, request_date) 
                      VALUES ('$donation_id', '$receiver_id', 'Pending', NOW())");

        // Update donation status
        $conn->query("UPDATE donations SET status='Pending' WHERE donation_id='$donation_id'");

        $_SESSION['message'] = "✅ Request sent successfully!";
    }

    // Redirect back to available donations
    header("Location: available_donations.php");
    exit();
} else {
    header("Location: available_donations.php");
    exit();
}
