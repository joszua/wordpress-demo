<?php

    function wordpress_demo_files() {
        wp_enqueue_style('roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('montserrat', '//fonts.googleapis.com/css2?family=Montserrat&display=swap');
        wp_enqueue_style('kaushan', '//fonts.googleapis.com/css2?family=Kaushan+Script&display=swap');
        wp_enqueue_style('kanit', '//fonts.googleapis.com/css2?family=Kanit&display=swap');
        wp_enqueue_style('ubuntu', '//fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap');
        
        wp_enqueue_style('fa-icons', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');
        wp_enqueue_style('mdi-icons', '//fonts.googleapis.com/css2?family=Material+Icons+Outlined');
        // wp_enqueue_style('icon-themify', '//cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css');

        wp_enqueue_style('wordpress_demo_styles', get_stylesheet_uri());
        wp_enqueue_style('main-styles-vendor', get_theme_file_uri('/build/index.css'));
        wp_enqueue_style('main-styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('sweetal-styles', get_theme_file_uri('/build/sweetalert.min.css'));
        wp_enqueue_style('toastr-styles', get_theme_file_uri('/build/toastr.min.css'));

        wp_enqueue_script('jquery-plugin', 'https://code.jquery.com/jquery-3.6.3.min.js', NULL, '1.0', true);
        wp_enqueue_script('sweetal-js', get_theme_file_uri('/js/sweetalert.min.js'), NULL, '1.0', true);
        wp_enqueue_script('toastr-js', get_theme_file_uri('/js/toastr.min.js'), NULL, '1.0', true);
        wp_enqueue_script('demo-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_script('function-js', get_theme_file_uri('/js/function.js'), array('jquery'), '1.0', true);
        
        wp_localize_script('demo-js', 'demoData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
        ));
    }

    add_action('wp_enqueue_scripts', 'wordpress_demo_files');
    
    function demo_features() {
        add_theme_support('title-tag');
    }

    add_action('after_setup_theme', 'demo_features');

    function featuredImageSupport_setup() {
        //Navigation Menu
        register_nav_menus(array(
            'primary' => __( 'Primary Menu'),
            'footer' => __( 'Footer Menu'),
        ));

        //Add featured image support
        add_theme_support('post-thumbnails');
    }

    add_action('after_setup_theme', 'featuredImageSupport_setup');

    function relative_date($time) {
        $time    = strtotime($time);
        $today   = strtotime(date('M j, Y'));
        $hrs     = date("h:i A", $time);
        $reldays = ($time - $today)/86400;
        if ($reldays >= 0 && $reldays < 1) {
            return 'Today, '.$hrs;
        } else if ($reldays >= 1 && $reldays < 2) {
            return 'Tomorrow, '.$hrs;
        } else if ($reldays >= -1 && $reldays < 0) {
            return 'Yesterday, '.$hrs;
        }
            
        if (abs($reldays) < 7) {
            if ($reldays > 0) {
                $reldays = floor($reldays);
                return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
            } else {
                $reldays = abs(floor($reldays));
                return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
            }
        }
            
        if (abs($reldays) < 182) {
            return date('l, j F',$time ? $time : time());
        } else {
            return date('l, j F, Y',$time ? $time : time());
        }
    }
        
    add_action( 'wp_ajax_nopriv_delete_post', 'delete_post' );
    add_action( 'wp_ajax_delete_post', 'delete_post' );
    function delete_post() {
        /* 
            * Extract the data in from this code "$_POST"
            * Ajax or Javascript sends you this data from the form in an array
        */ 

        // Return data to Javascript
        $confirmDelete = wp_delete_post($_POST['post_id']);

        if ($confirmDelete) {
            echo json_encode([
            'code'     => 200,
            'status'    => true,
            'data'      => $_POST['post_id'], 
            'msg'      => 'Post deleted successfully.',
        ]);
        } else {
            echo json_encode([
            'code'     => 200,
            'status'    => false,
            'data'      => $_POST['post_id'], 
            'msg'      => 'Post deleted successfully.',
        ]);
        }
    }

    add_action( 'wp_ajax_nopriv_create_post', 'create_post' );
    add_action( 'wp_ajax_create_post', 'create_post' );
    function create_post() {
        /* 
            * Extract the data in from this code "$_POST"
            * Ajax or Javascript sends you this data from the form in an array
        */ 

        // Return data to Javascript
        $new_post = array(
        'post_title' => $_POST['post_title'],
        'post_content' => $_POST['post_description'],
        'post_type' => 'post',
        'post_status' => 'publish'
        );

        if ($_POST['post_id']) {
            $new_post['ID'] = $_POST['post_id'];
            wp_update_post( $new_post );
            $post_id = $_POST['post_id'];
        } else {
            $post_id = wp_insert_post($new_post);
        }
        


        if($post_id) {
            $post_img_id = upload_files_and_save($post_id, '');
            if($post_img_id) {
               update_field('featured_image', $post_img_id, $post_id); 
            }
            update_field('featured_post', $_POST['featured_post'], $post_id);

        }
            echo json_encode([
            'code'     => 200,
            'status'    => ($post_id) ? true : false,
            'data'      => [], 
            'msg'      => ($post_id) ? 'Post saved successfully.' : 'A problem occured. Please try again',
        ]);
    }

    add_action( 'wp_ajax_nopriv_add_phone', 'add_phone' );
    add_action( 'wp_ajax_add_phone', 'add_phone' );
    function add_phone() {
        /* 
            * Extract the data in from this code "$_POST"
            * Ajax or Javascript sends you this data from the form in an array
        */ 

        // Return data to Javascript
        $new_post = array(
        'post_title' => $_POST['brand'],
        'post_type' => 'phone',
        'post_status' => 'publish',
        'meta_input' => array(
            'released' => $_POST['released'],
            'technology' => $_POST['technology'],
            'sim' => $_POST['sim'],
            'size' => $_POST['size'],
            'resolution' => $_POST['resolution'],
            'os' => $_POST['os'],
            'chipset' => $_POST['chipset'],
            'rom' => $_POST['rom'],
            'ram' => $_POST['ram'],
            'camera_rear' => $_POST['cam_rear'],
            'camera_front' => $_POST['cam_front'],
            'battery' => $_POST['battery'],
            'model' => $_POST['model'],
            'price' => $_POST['price'],
        )
        );

        if ($_POST['post_id']) {
            $new_post['ID'] = $_POST['post_id'];
            wp_update_post( $new_post );
            $post_id = $_POST['post_id'];
        } else {
            $post_id = wp_insert_post($new_post);
        }
        


        if($post_id) {
            $post_img_id = upload_files_and_save($post_id, '');
            if($post_img_id) {
               update_field('featured_image', $post_img_id, $post_id); 
            }
            update_field('featured_post', $_POST['featured_post'], $post_id);

        }
            echo json_encode([
            'code'     => 200,
            'status'    => ($post_id) ? true : false,
            'data'      => [], 
            'msg'      => ($post_id) ? 'Post saved successfully.' : 'A problem occured. Please try again',
        ]);
    }

    // Upload Files
    function upload_files_and_save($post_id, $attach_id) {
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        // for multiple file upload.
        $upload_overrides = array( 'test_form' => false );
        $files = $_FILES['post_image'];
        if($_FILES['post_image']['name']){
            if ( $files['name'] ) {
                $file = array(
                    'name'         => $files['name'],
                    'type'         => $files['type'],
                    'tmp_name'     => $files['tmp_name'],
                    'error'     => $files['error'],
                    'size'         => $files['size']
                );
        
                $movefile = wp_handle_upload( $file, $upload_overrides );

                if ( $movefile && !isset($movefile['error']) ) {
                    $wp_upload_dir = wp_upload_dir();
                    $attachment = array(
                        'guid'              => $wp_upload_dir['url'] . '/' . basename($movefile['file']),
                        'post_mime_type' => $movefile['type'],
                        'post_title'      => preg_replace( '/\.[^.]+$/','', basename($movefile['file'])),
                        'post_content'      => '',
                        'post_status'      => 'inherit'
                    );
                    $attach_id = wp_insert_attachment($attachment, $movefile['file']);
                    if($attach_id){
                        set_post_thumbnail( $post_id, $attach_id );
                    }else{
                        set_post_thumbnail( $post_id, $post_img_id );
                    }
                }
            }
        }
        return $attach_id;
    }

    add_action( 'wp_ajax_nopriv_mod_feature', 'mod_feature' );
    add_action( 'wp_ajax_mod_feature', 'mod_feature' );
    function mod_feature() {

        update_field('featured_post', $_POST['featured_post'], $_POST['post_id']);
            echo json_encode([
            'code'     => 200,
            'status'    => true,
            'data'      => $_POST['post_id'], 
            'msg'      => 'Post featured successfully.',
        ]);

    }

    add_action( 'wp_ajax_nopriv_fetch_post', 'fetch_post' );
    add_action( 'wp_ajax_fetch_post', 'fetch_post' );
    function fetch_post() {
        $args = array(
            'post_type'      => array('post'),
            'p'             => $_POST['post_id'], 
        );
        $query = new WP_Query( $args );
        $post = $query->posts[0];

        // Return data to Javascript
        echo json_encode([
            'code' => 200,
            'status' => true,
            'data' => array(
                'post_id'          => $post->ID,
                'post_title'       => $post->post_title,
                'post_description' => $post->post_content,
                'featured_post'    => (get_field('featured_post', $post->ID) == 'Yes') ? 'Yes' : 'No',
                'featured_image'   => (get_field('featured_image', $post->ID)) ? get_field('featured_image', $post->ID) : '/wp-content/themes/newthemedemo/images/library-hero.jpg',
            ),
            'msg' => 'Post fetched successfully.',
        ]);
    }

    add_action( 'wp_ajax_nopriv_fetch_phone', 'fetch_phone' );
    add_action( 'wp_ajax_fetch_phone', 'fetch_phone' );
    function fetch_phone() {
        $args = array(
            'post_type'      => array('phone'),
            'p'             => $_POST['post_id'], 
        );
        $query = new WP_Query( $args );
        $post = $query->posts[0];

        $date = date('Y-m-d',strtotime($post->released)); //converts mySQL date to HTML date

        // Return data to Javascript
        echo json_encode([
            'code' => 200,
            'status' => true,
            'data' => array(
                'post_id'     => $post->ID,
                'brand'       => $post->post_title,
                'released'    => $date,
                'technology' => $post->technology,
                'sim' => $post->sim,
                'size' => $post->size,
                'resolution' => $post->resolution,
                'os' => $post->os,
                'chipset' => $post->chipset,
                'rom' => $post->rom,
                'ram' => $post->ram,
                'cam_rear' => $post->camera_rear,
                'cam_front' => $post->camera_front,
                'battery' => $post->battery,
                'model' => $post->model,
                'price' => $post->price,
                'featured_post'    => (get_field('featured_post', $post->ID) == 'Yes') ? 'Yes' : 'No',
                'featured_image'   => (get_field('featured_image', $post->ID)) ? get_field('featured_image', $post->ID) : '/wp-content/themes/newthemedemo/images/library-hero.jpg',
            ),
            'msg' => 'Post fetched successfully.',
        ]);
    }
