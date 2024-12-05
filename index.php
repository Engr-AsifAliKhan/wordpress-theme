<?php
// Include the header template
get_header(); ?>

<div id="main-content">
    <section>
        <?php if (have_posts()) : ?>
            <h2>Latest Posts</h2>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>">Read More</a>
                    </footer>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </section>
</div>

<?php
// Include the footer template
get_footer();
