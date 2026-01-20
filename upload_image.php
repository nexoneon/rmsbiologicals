<?php
// Image upload handler for admin dashboard
header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'filename' => ''];

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $response['message'] = 'No file uploaded or upload error occurred';
    echo json_encode($response);
    exit;
}

// Configuration
$uploadDir = 'uploads/';
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Create upload directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$file = $_FILES['image'];
$fileSize = $file['size'];
$fileType = $file['type'];
$fileTmpName = $file['tmp_name'];
$originalName = $file['name'];

// Validate file type
if (!in_array($fileType, $allowedTypes)) {
    $response['message'] = 'Invalid file type. Only JPG, PNG, GIF, and WebP images are allowed.';
    echo json_encode($response);
    exit;
}

// Validate file size
if ($fileSize > $maxFileSize) {
    $response['message'] = 'File size exceeds 5MB limit.';
    echo json_encode($response);
    exit;
}

// Generate unique filename
$fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$newFilename = uniqid('img_', true) . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFilename;

// Move uploaded file
if (move_uploaded_file($fileTmpName, $uploadPath)) {
    $response['success'] = true;
    $response['message'] = 'Image uploaded successfully!';
    $response['filename'] = $newFilename;
    $response['url'] = $uploadPath;
} else {
    $response['message'] = 'Failed to move uploaded file.';
}

echo json_encode($response);
?>
