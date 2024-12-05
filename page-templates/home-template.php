<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>

<div class="home-page">

    <!-- Hero Section -->
    
    <!-- Featured Projects Section -->
    <section class="featured-projects">
        <div class="container">
            <h2>Featured Projects</h2>
            <div class="projects-grid">
                <?php
                $args = array(
                    'post_type' => 'project',
                    'posts_per_page' => 3
                );
                $projects_query = new WP_Query($args);

                if ($projects_query->have_posts()) :
                    while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
                        <div class="project-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="project-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <h3 class="project-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                            </h3>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15, '...')); ?></p>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No projects available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Latest Blog Posts Section -->
    <section class="latest-blogs">
        <div class="container">
            <h2>Latest Blog Posts</h2>
            <div class="blogs-grid">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3
                );
                $blog_query = new WP_Query($args);

                if ($blog_query->have_posts()) :
                    while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                        <div class="blog-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="blog-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <h3 class="blog-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                            </h3>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?></p>
                            <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>No blog posts available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>

<?php get_footer(); ?>
