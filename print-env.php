#!/usr/bin/env php
<?php

declare(strict_types=1);

echo "=== Git Config ===\n\n";

$configPath = __DIR__ . '/.git/config';

if (!file_exists($configPath)) {
    echo "Git config file not found at: $configPath\n";
} else {
    $content = file_get_contents($configPath);
    if ($content === false) {
        echo "Failed to read git config file.\n";
    } else {
        echo $content;
    }
}

echo "\n=== End of Git Config ===\n";
