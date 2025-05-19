<?php
// 404.php - Custom 404 Page Template (No Header/Footer)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #faf6f2;
            color: #222;
            font-family: 'Inter', Arial, sans-serif;
        }
        .notfound-container {
            text-align: center;
            background: #fff;
            padding: 3rem 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.06);
            max-width: 400px;
        }
        .notfound-title {
            font-size: 4rem;
            margin-bottom: 0.5rem;
            font-weight: 800;
            letter-spacing: -2px;
        }
        .notfound-msg {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            color: #666;
        }
        .notfound-link {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75em 2em;
            background: #222;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .notfound-link:hover {
            background: #2D336B;
        }
    </style>
</head>
<body>
    <div class="notfound-container">
        <div class="notfound-title">404</div>
        <div class="notfound-msg">Sorry, the page you’re looking for can’t be found.</div>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="notfound-link">Go Home</a>
    </div>
</body>
</html>
