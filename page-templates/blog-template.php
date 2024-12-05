<?php
/**
 * Template Name: Blog Page
 */

get_header(); ?>

<div class="blog-page container">
    <h1 class="page-title"><?php the_title(); ?></h1>
    
    <div class="blog-grid">
        <?php
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 10,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // Add pagination support
        );
        $blog_query = new WP_Query($args);
        
        if ($blog_query->have_posts()) :
            while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                <article class="blog-post">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="post-content">
                        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <span class="date"><?php echo get_the_date(); ?></span>
                            <span class="author">By <?php the_author(); ?></span>
                        </div>
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>No blog posts found.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $blog_query->max_num_pages,
        ));
        ?>
    </div>
</div>

<?php get_footer(); ?>
