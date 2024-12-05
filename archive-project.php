<?php
// Include the header template
get_header(); 

// Handle the form inputs for filtering
$start_date_filter = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
$end_date_filter = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

// Modify the query to filter by Start Date and End Date if values are provided
$args = array(
    'post_type' => 'project',
    'posts_per_page' => -1, // Show all projects
);

$meta_query = array('relation' => 'AND');

// Add start date filter to the query
if ($start_date_filter) {
    $meta_query[] = array(
        'key' => 'project_start_date',
        'value' => $start_date_filter,
        'compare' => '>=',
        'type' => 'DATE'
    );
}

// Add end date filter to the query
if ($end_date_filter) {
    $meta_query[] = array(
        'key' => 'project_end_date',
        'value' => $end_date_filter,
        'compare' => '<=',
        'type' => 'DATE'
    );
}

if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
}

$query = new WP_Query($args);
?>

<div id="project-archive" class="container">
    <!-- Filter Form -->
    <form method="get" class="filter-form">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo esc_attr($start_date_filter); ?>">
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo esc_attr($end_date_filter); ?>">
        </div>
        <button type="submit" class="btn">Filter</button>
    </form>

    <!-- Projects List -->
    <?php if ($query->have_posts()) : ?>
        <header class="archive-header">
            <h1 class="archive-title">Projects Archive</h1>
        </header>
        <div class="projects-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="project-box">
                    <header class="project-header">
                        <h2 class="project-title"><?php echo esc_html(get_the_title()); ?></h2>
                    </header>
                    <div class="project-meta">
                        <?php 
                        // Fetch and display Start Date
                        $start_date = get_post_meta(get_the_ID(), 'project_start_date', true);
                        echo $start_date 
                            ? '<p class="project-start-date">Start Date: ' . esc_html($start_date) . '</p>' 
                            : '<p class="project-start-date">Start Date: Not Available</p>';
                        ?>
                    </div>
                    <footer class="project-footer">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="btn">Project Details</a>
                        <?php 
                        // Fetch and display Project URL
                        $project_url = get_post_meta(get_the_ID(), 'project_url', true);
                        echo $project_url 
                            ? '<a href="' . esc_url($project_url) . '" class="btn">Project Website</a>' 
                            : '<a href="#" class="btn disabled">Project Website (Not Available)</a>';
                        ?>
                    </footer>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>No projects found matching your criteria.</p>
    <?php endif; ?>
</div>

<?php
// Reset post data
wp_reset_postdata();

// Include the footer template
get_footer(); 
?>
