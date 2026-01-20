<?php
// Database connection for admin
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Category CRUD Functions
function getAllCategories() {
    global $conn;
    $sql = "SELECT * FROM categories ORDER BY name";
    $result = $conn->query($sql);
    $categories = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

function getCategoryById($id) {
    global $conn;
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

function addCategory($name, $description, $icon, $status = 'active') {
    global $conn;
    $sql = "INSERT INTO categories (name, description, icon, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $description, $icon, $status);
    
    return $stmt->execute();
}

function updateCategory($id, $name, $description, $icon, $status) {
    global $conn;
    $sql = "UPDATE categories SET name = ?, description = ?, icon = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $description, $icon, $status, $id);
    
    return $stmt->execute();
}

function deleteCategory($id) {
    global $conn;
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

// Helper function to get category product count
function getCategoryProductCount($categoryId) {
    global $conn;
    // This would be based on your products table structure
    // For now, returning a placeholder
    return 0;
}
?>