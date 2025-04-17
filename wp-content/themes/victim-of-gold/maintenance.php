<?php
require_once('../../../wp-load.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #000;
            font-family: Arial, sans-serif;
        }
        .maintenance-container {
            text-align: center;
            padding: 20px;
        }
        .maintenance-image {
            max-width: 100%;
            height: auto;
            margin-top: 30px;
        }
        .coming-soon {
            color: #957B4D;
            font-size: 48px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <h1 class="coming-soon">COMING SOON</h1>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/maintenance.jpg" alt="Maintenance" class="maintenance-image">
    </div>
</body>
</html> 