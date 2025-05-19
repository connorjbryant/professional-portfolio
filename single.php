<?php
get_header();
?>
<div style="height: 6.5rem;"></div> <!-- Spacer for fixed nav -->
<main aria-label="Main content" class="<?php if (is_singular()) echo 'main--single-pattern'; ?>">
  <div class="pattern-bg"></div>
  <div class="site-wrap">
    <section class="single-post" aria-label="Single post section">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="single-post__container" data-aos="fade-up" aria-label="Post container">
        <section class="single-post__header" aria-label="Post header">
          <h1 class="single-post__title post-heading" aria-label="Post title"><?php the_title(); ?></h1>
          <?php
          $tags = get_the_tags();
          if ($tags) {
              echo '<div class="single-post__tags">With: ';
              $tag_names = array();
              foreach ($tags as $tag) {
                  $tag_names[] = esc_html($tag->name);
              }
              echo implode(', ', $tag_names);
              echo '</div>';
          }
          if ( has_post_thumbnail() ) {
              the_post_thumbnail('full', array('class' => 'single-post-featured-image border-image'));
          }
          ?>
        </section>
       
        <section class="single-post__about" aria-label="About this post">
          <h2 class="single-post__about-title" aria-label="About this post heading">About This Project</h2>
          <div class="single-post__body" aria-label="Post body">
            <?php the_content(); ?>
          </div>
        </section>
        <?php
        // --- Details (ACF text field)
        $details = get_field('details');
        if (!empty($details)) :
          $details_array = array_map('trim', explode(',', $details));
          $details_with_bullets = implode(' • ', $details_array);
          ?>
          <section class="single-post__details" aria-label="Skills and technologies">
            <div class="single-post__details-label" aria-label="Skills and technologies label">SKILLS & TECH</div>
            <div class="single-post__details-text acf-details" aria-label="Skills and technologies text">
              <?php echo esc_html($details_with_bullets); ?>
            </div>
          </section>
        <?php endif; ?>
      </article>
    <?php endwhile; else: ?>
      <p>Sorry, no post found.</p>
    <?php endif; ?>
  </section>
  </div><!-- .site-wrap -->
</main>
<?php get_footer(); ?>
