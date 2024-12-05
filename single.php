<?php
get_header(); ?>

<div class="single-blog-post container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <header class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span class="date"><?php echo get_the_date(); ?></span>
                    <span class="author">By <?php the_author(); ?></span>
                </div>
            </header>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <footer class="post-footer">
                <div class="post-categories">
                    <strong>Categories:</strong> <?php the_category(', '); ?>
                </div>
                <div class="post-tags">
                    <?php if (has_tag()) : ?>
                        <strong>Tags:</strong> <?php the_tags('', ', ', ''); ?>
                    <?php endif; ?>
                </div>
            </footer>
        </article>

        <!-- Comments Section -->
        <div class="comments-section">
            <?php if (comments_open() || get_comments_number()) :
                comments_template();
            endif; ?>
        </div>

    <?php endwhile; else : ?>
        <p>No content found</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>