<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Start transaction
    $conn->beginTransaction();
    
    // Disable foreign key checks
    $conn->exec('SET FOREIGN_KEY_CHECKS=0');
    
    // Truncate tables
    $conn->exec('TRUNCATE TABLE order_items');
    $conn->exec('TRUNCATE TABLE products');
    
    // Insert new products
    $sql = "INSERT INTO products (name, description, price, stock, category, image_url) VALUES
    ('Cricket Bat', 'Professional grade cricket bat made from premium English willow', 1500000, 10, 'Cricket Equipment', '/assets/images/cricket-bat.jpg'),
    ('Cricket Ball', 'Premium leather cricket ball suitable for match play', 250000, 30, 'Cricket Equipment', '/assets/images/cricket-ball.jpg'),
    ('Batting Gloves', 'Professional batting gloves with extra protection', 300000, 20, 'Cricket Equipment', '/assets/images/batting-gloves.jpg'),
    ('Cricket Helmet', 'Safety-certified cricket helmet with adjustable fit', 500000, 15, 'Cricket Equipment', '/assets/images/cricket-helmet.jpg'),
    ('Cricket Pads', 'Lightweight and durable batting pads', 450000, 25, 'Cricket Equipment', '/assets/images/batting-pads.jpg'),
    ('Cricket Shoes', 'Professional cricket shoes with spikes', 800000, 20, 'Cricket Equipment', '/assets/images/cricket-shoes.jpg'),
    ('Cricket Kit Bag', 'Large capacity kit bag with wheels', 600000, 15, 'Accessories', '/assets/images/kit-bag.jpg'),
    ('Cricket Stumps', 'Professional wooden stumps with bails', 350000, 10, 'Cricket Equipment', '/assets/images/stumps.jpg'),
    ('Wicket Keeping Gloves', 'Premium wicket keeping gloves', 400000, 12, 'Cricket Equipment', '/assets/images/keeping-gloves.jpg'),
    ('Cricket Jersey', 'Official team cricket jersey', 250000, 50, 'Apparel', '/assets/images/jersey.jpg')";
    
    $conn->exec($sql);
    
    // Re-enable foreign key checks
    $conn->exec('SET FOREIGN_KEY_CHECKS=1');
    
    // Commit transaction
    $conn->commit();
    
    echo "Database updated successfully!";
    
} catch(PDOException $e) {
    // Rollback transaction on error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "Error updating database: " . $e->getMessage();
} 