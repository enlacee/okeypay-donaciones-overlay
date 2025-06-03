<?php

/**
 * Useful for reset all data
 * Delete all files .json
 * 
 **/

$files = glob(__DIR__ . '/*.json');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
