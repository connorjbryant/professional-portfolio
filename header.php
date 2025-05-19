<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
  <div class="nav-wrap">
    <div class="nav-left">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="Home - Connor Bryant" role="button">Connor Bryant</a>
    </div>
    <nav class="nav-right" role="navigation" aria-label="Main navigation">
    <a href="/about" class="nav-link" aria-label="About section" role="button">About</a>
      <a href="/wp-content/uploads/2025/05/Resume-C-Bryant.pdf" class="nav-link" target="_blank" aria-label="Resume section" role="button">Resume</a>
    </nav>

  </div>
</header>
