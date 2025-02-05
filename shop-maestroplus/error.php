<?php
http_response_code($_SERVER['REDIRECT_STATUS']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - MAESTROPLUS+</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/main.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-red-600 mb-4">
                <?= $_SERVER['REDIRECT_STATUS'] ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                <?php
                switch($_SERVER['REDIRECT_STATUS']) {
                    case 404:
                        echo "Page not found";
                        break;
                    case 403:
                        echo "Access forbidden";
                        break;
                    default:
                        echo "An error occurred";
                }
                ?>
            </p>
            <a href="<?= BASE_URL ?>" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html> 