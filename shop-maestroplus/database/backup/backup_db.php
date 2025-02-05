<?php
require_once '../includes/config.php';

try {
    // Set the backup file path
    $backupFile = __DIR__ . '/backup/maestroplus_' . date('Y-m-d_H-i-s') . '.sql';
    
    // Make sure backup directory exists
    if (!file_exists(__DIR__ . '/backup')) {
        mkdir(__DIR__ . '/backup', 0777, true);
    }
    
    // Create backup command
    $command = sprintf(
        'mysqldump -h %s -u %s %s %s > %s',
        DB_HOST,
        DB_USER,
        DB_PASS ? '-p' . DB_PASS : '',
        DB_NAME,
        $backupFile
    );
    
    // Execute backup
    system($command, $returnVar);
    
    if ($returnVar === 0) {
        echo "Database backup created successfully at: " . $backupFile;
    } else {
        throw new Exception("Error creating backup");
    }
    
} catch(Exception $e) {
    echo "Backup failed: " . $e->getMessage();
} 