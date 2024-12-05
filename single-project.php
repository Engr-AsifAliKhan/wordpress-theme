<?php get_header(); ?>

<div class="project-container">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
        // Fetch project metadata and escape the values to ensure safety
        $start_date = get_post_meta(get_the_ID(), 'project_start_date', true);
        $end_date = get_post_meta(get_the_ID(), 'project_end_date', true);
        $url = get_post_meta(get_the_ID(), 'project_url', true);
    ?>
        <div class="project-card">
            <h1 class="project-title"><?php the_title(); ?></h1>
            
            <!-- Escaping the start date and end date to avoid XSS attacks -->
            <p class="project-meta">Start Date: <?php echo $start_date ? esc_html($start_date) : 'Not Available'; ?></p>
            <p class="project-meta">End Date: <?php echo $end_date ? esc_html($end_date) : 'Not Available'; ?></p>
            
            <!-- Display the project URL securely -->
            <?php if ($url) : ?>
                <p class="project-meta">
                    Project URL: 
                    <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_url($url); ?></a>
                </p>
            <?php else : ?>
                <p class="project-meta">Project URL: Not Available</p>
            <?php endif; ?>
            
            <div class="project-content">
                <?php the_content(); ?>
            </div>
            
            <!-- Link to project URL with escaping to prevent unsafe URLs -->
            <?php if ($url) : ?>
                <a href="<?php echo esc_url($url); ?>" class="project-link" target="_blank">Visit Project Website</a>
            <?php else : ?>
                <a href="<?php the_permalink(); ?>" class="project-link">Visit Project Details</a>
            <?php endif; ?>
        </div>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
