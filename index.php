<?php get_header(); ?>
<div style="height: 6.5rem;"></div> <!-- Spacer for fixed nav -->
<main class="main" aria-label="Main content">
  <!-- Hero Section -->
  <section id="hero" class="main__hero" data-aos="fade-up" aria-label="Hero section">
    <div class="main__hero-img">
      <img src="/wp-content/uploads/2025/05/Bryant-JDA_1280x1280px-1.jpg" alt="Portrait" class="main__hero-portrait" />
    </div>
    <div class="main__hero-content">
      <div class="main__hero-bio">
        <h1 class="main__hero-greeting" data-aos="fade-up" data-aos-delay="0" aria-label="Hero greeting">Hello.</h1>
        <h2 class="main__hero-subtitle" data-aos="fade-up" data-aos-delay="200" aria-label="Hero description">I create memorable web experiences using my skills in: <span class="responsive-br"><br /></span><span id="typewriter"></span></h2>
      </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="projects-section" aria-label="Projects section">
    <h2 data-aos="fade-up" data-aos-delay="50" aria-label="Projects heading">Project Showcase</h2>
    <div class="projects-list">
      <?php
      if ( have_posts() ) :
        $project_index = 0;
        while ( have_posts() ) : the_post();
          $project_index++;
          $is_mobile = wp_is_mobile();
          $is_first = ($project_index === 1);
          $add_animation = !($is_mobile && $is_first);
        ?>
        <div class="project-card"<?php if ($add_animation): ?> data-aos="fade-up" data-aos-delay="<?php echo ($project_index-1)*100; ?>"<?php endif; ?> aria-label="Project card">
          <div class="project-card__image-wrapper">
            <div class="project-card__image">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('full'); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="project-card__info">
            <h3 class="project-card__title" aria-label="Project title"><?php the_title(); ?></h3>
            <?php
              $tags = get_the_tags();
              if ($tags && count($tags) > 0) {
                $company = $tags[0]->name;
                echo '<div class="project-card__company" aria-label="Project company">With: ' . esc_html($company) . '</div>';
              }
            ?>
            <div class="project-card__excerpt" aria-label="Project excerpt">
            <?php
              $description = get_field('description');
              if ($description) {
                echo wp_kses_post($description);
              } else {
                the_excerpt();
              }
            ?>
            </div>
            <div class="project-card__buttons">
              <a href="<?php the_permalink(); ?>" class="project-card__link" aria-label="View project details">Development Process</a>
              <?php 
                // To show the Visit Website button, set a custom field 'project_url' for this post.
                $project_url = get_post_meta(get_the_ID(), 'project_url', true); 
                if ($project_url): ?>
                <a href="<?php echo esc_url($project_url); ?>" class="project-card__external-link" target="_blank" rel="noopener" aria-label="Visit project website (opens in new tab)">
                  <span>Visit Website</span>
                  <svg aria-hidden="true" width="1.1em" height="1.1em" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-left:0.2em;"><path d="M7.75 3.5A.75.75 0 0 1 8.5 2.75h8a.75.75 0 0 1 .75.75v8a.75.75 0 0 1-1.5 0V5.56l-8.22 8.22a.75.75 0 1 1-1.06-1.06L14.44 4.5H8.5a.75.75 0 0 1-.75-.75Z" fill="currentColor"/></svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; else: ?>
        <p class="projects-empty" aria-label="No projects found message">No posts found. Add some posts to display your work!</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Jobs Accordion Section -->
  <section id="jobs" class="jobs-section" data-aos="fade-up" aria-label="Jobs section">
    <h2 aria-label="Jobs heading">Where I've Worked</h2>
    <?php
    $jobs = new WP_Query(array(
      'post_type' => 'job',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ));
    if ($jobs->have_posts()): ?>
      <div class="jobs-accordion">
        <?php while ($jobs->have_posts()): $jobs->the_post();
          $company = get_field('company_name');
          $title = get_field('job_title');
          $location = get_field('location');
          $start = get_field('start_date');
          $end = get_field('end_date');
          $desc = get_field('description');
          $logo = get_field('logo');
          $tags = get_field('tags'); // adjust if using repeater
        ?>
  <div class="job-card">
  <button class="job-card__header js-job-card-header" aria-expanded="false">
    <div class="job-card__header-inner">
      <?php if ($logo): ?>
        <div class="job-card__logo-wrap">
          <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($company); ?>" class="job-card__logo">
        </div>
      <?php endif; ?>
      <div class="job-card__main-info">
        <div class="job-card__meta-row">
          <div class="job-card__meta-left">
            <span class="job-card__company"><?php echo esc_html($company); ?></span>
            <span class="job-card__title">
              <?php echo esc_html($title); ?>
              <?php $jobtype = get_field('job_type'); if ($jobtype): ?>
                <span class="job-card__type">(<?php echo esc_html($jobtype); ?>)</span>
              <?php endif; ?>
            </span>
          </div>
          <div class="job-card__meta-right-group">
            <div class="job-card__meta-right">
              <?php if ($start || $end): ?>
                <span class="job-card__dates">
                <?php
                  $start_formatted = $start ? date('m/Y', strtotime($start)) : '';
                  $end_formatted = $end ? date('m/Y', strtotime($end)) : 'Present';
                  echo esc_html($start_formatted);
                  if ($start_formatted) echo ' – ';
                  echo esc_html($end_formatted);
                ?>
                </span>
              <?php endif; ?>
              <?php if ($location): ?>
                <span class="job-card__location"><?php echo esc_html($location); ?></span>
              <?php endif; ?>
            </div>
            <span class="job-card__arrow" aria-hidden="true">
              <svg class="job-card__arrow-icon" width="22" height="22" viewBox="0 0 20 20" fill="none"><path d="M6 8l4 4 4-4" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
          </div>
        </div>
      </div>
    </div>
  </button>
  <div class="job-card__body js-job-card-body" hidden>
            <?php $jobsummary = get_field('job_summary'); if ($jobsummary): ?>
              <div class="job-card__summary job-card__summary--expanded"><?php echo wp_kses_post($jobsummary); ?></div>
            <?php endif; ?>
            <?php if ($tags): ?>
  <div class="job-card__tags-wrap">
    <div class="job-card__tags-heading">Tech Stack</div>
    <div class="job-card__tags">
      <?php
      // If tags is a comma-separated string, split it into an array
      if (!is_array($tags)) {
        $tags = explode(',', $tags);
      }
      foreach ($tags as $tag): ?>
        <span class="job-card__tag"><?php echo esc_html(trim(is_array($tag) && isset($tag['tag']) ? $tag['tag'] : $tag)); ?></span>
      <?php endforeach; ?>
        </div>
        </div>
        <?php endif; ?>
            <div class="job-card__desc">
              <?php echo $desc; ?>
            </div>
          </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else: ?>
      <p class="jobs-empty" aria-label="No jobs found message">No jobs found. Add some jobs to display your work experience!</p>
    <?php endif; ?>
  </section>

  <section id="contact" class="main__contact" aria-label="Contact section">
    <h2 class="main__contact-title" data-aos="fade-up" data-aos-delay="200" aria-label="Contact heading">Contact</h2>
    <p class="main__contact-text" data-aos="fade-up" data-aos-delay="200" aria-label="Contact email">For inquiries, email <a href="mailto:connorjamesbryant7@gmail.com" aria-label="Email Connor Bryant">connorjamesbryant7@gmail.com</a></p>
	<p class="main__contact-text" data-aos="fade-up" data-aos-delay="200" aria-label="Contact email">Feel free to follow me on <a href="https://github.com/connorjbryant" target="_blank" aria-label="GitHub Connor Bryant">GitHub</a>.</p>
  </section>
</main>
<?php get_footer(); ?>
