<?php
    get_header();
    while(have_posts()) {
        the_post();
        $post_id = get_the_ID();
        $featured_img_url = get_field('featured_image', $post_id); ?>  
            
        <div class="page-banner">
            <div class="post-banner__bg-image" style="background-image: url(<?=$featured_img_url ? $featured_img_url : get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <div class="page-banner__intro">
                <p style="font-size: 18px"><b>Author:</b> <?php the_author(); ?></p>
                <p style="font-size: 15px; color: darkgrey">Date: <?php the_date('F j, Y g:i A'); ?></p>
                </div>
            </div>
        </div>

        <div class="container container--narrow page-section">
        <?php
            $parentID = wp_get_post_parent_id(get_the_ID());
            if ($parentID) { ?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentID); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentID); ?> </a> <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                </div>
            <?php } 
        ?>

        <?php
            $getPage = get_pages(array(
                'child_of' => get_the_ID()
            ));

            if ($parentID || $getPage) { ?>
            <div class="page-links">
                    <h2 class="page-links__title"><a href="<?php echo get_the_permalink($parentID) ?>"><?php echo get_the_title($parentID) ?></a></h2>
                    <ul class="min-list">
                        <?php
                            if ($parentID) {
                                $temp_children = $parentID;
                            } else {
                                $temp_children = get_the_ID();
                            }

                            wp_list_pages(array(
                                'title_li' => NULL,
                                'child_of' => $temp_children,
                                'sort_column' => 'menu_order'
                            ));
                        ?>
                    </ul>
                </div>
            <?php }
        ?>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
        </div>
    <?php }
    get_footer();
?>