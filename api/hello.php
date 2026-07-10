<?php
header('content-type: application/json');
echo json_encode(['ok' => true, 'php' => PHP_VERSION]);