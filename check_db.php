<?php
require 'includes/db.php';

try {
    // Check if reminders table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'reminders'");
    $tableExists = $stmt->rowCount() > 0;
    
    echo "Reminders table exists: " . ($tableExists ? "Yes" : "No") . "\n";
    
    if ($tableExists) {
        // Get table structure
        $stmt = $pdo->query("DESCRIBE reminders");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nTable structure:\n";
        foreach ($columns as $column) {
            echo $column['Field'] . " - " . $column['Type'] . "\n";
        }
        
        // Count reminders
        $stmt = $pdo->query("SELECT COUNT(*) FROM reminders");
        $count = $stmt->fetchColumn();
        echo "\nTotal reminders in database: " . $count . "\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 