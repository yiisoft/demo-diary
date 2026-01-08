#!/usr/bin/env php
<?php

declare(strict_types=1);

echo "=== Environment Variables ===\n\n";

$envVars = getenv();

if (empty($envVars)) {
    echo "No environment variables found.\n";
} else {
    ksort($envVars);

    foreach ($envVars as $key => $value) {
        echo sprintf("%s=%s\n", $key, $value);
    }

    echo "\n";
    echo sprintf("Total: %d environment variables\n", count($envVars));
}

echo "\n=== End of Environment Variables ===\n";
