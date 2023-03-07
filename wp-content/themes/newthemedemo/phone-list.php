<?php
   /*
      Template Name: Phone Template
   */ 
   get_header();  ?>
   <?php
      $paged                   = 1;
      $paginate_url            = explode("/", $_SERVER['REQUEST_URI']);
      // Search Field
      $keyword = isset($_GET['search']) ? $_GET['search'] : '';

      if(count($paginate_url) == 5){
         if($paginate_url[2] == 'page'){
            $paged = $paginate_url[3];
         }
      }
      function pagination( $paged = '', $max_page = '' )
      {
         if( !$paged )
            $paged = get_query_var('paged');
         if( !$max_page )
            $max_page = $wp_query->max_num_pages;
         return paginate_links( array(
            'current'    => max(1, $paged),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text'  => __('<span class="material-icons-outlined">arrow_back_ios</span>'),
            'next_text'  => __('<span class="material-icons-outlined">arrow_forward_ios</span>'),
            'type'       => 'block'
         ) );
      }
      $args = array(
         'post_type'      => array('code'),
         'post_status'    => 'publish',
         'posts_per_page' => 50, // default 50
         'paged'          => $paged,
         'orderby'        => 'date',
         'sort_order'     => 'ASC',
         's'              => $keyword,
      );
      $query = new WP_Query( $args );
      $posts = $query->posts;
   ?>

   <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/polygonal-bg.jpg')?>)"></div>
      <div class="page-banner__content container container--narrow">
         <h1 class="phone-banner__title"><?php the_title(); ?></h1>
      </div>
   </div>

   <?php
   $args = array(
         'post_type'      => array('phone'),
         'post_status'    => 'publish',
         'posts_per_page' => 1, 
         'orderby'        => 'date',
         'order'          => 'ASC',
         'paged'          => $paged,
         's'              => $keyword,
   );
   $query = new WP_Query( $args );
   $posts = $query->posts;
   ?>
   <?php if($posts) { ?>
      <div class="blog-wrapper" style="background-color: aliceblue;">
         <div class="top-bar">
            <button class="create" type="button" onclick="openPostForm()"><i style="margin-left: -8px;padding-right: 8px;" class="fa-sharp fa-solid fa-pen"></i>Create a new post</button>
            <div class="custom-search-wrapper">
               <form action="/phone-list" method="get">
                  <input type="search" name="search" id="search-input" class="input-search" value="<?=$keyword;?>" placeholder="Search phone...">
                  <button type="submit" class="btn-search"><span class="material-icons-outlined">search</span></button>
               </form>
            </div>
         </div>

         <ul>
            <?php foreach($posts as $post) { ?>
               <?php
                  $os = get_field('os', $post->ID);
                  $chipset = get_field('chipset', $post->ID);
                  $rom = get_field('rom', $post->ID);
                  $ram = get_field('ram', $post->ID);
                  $rear = get_field('camera_rear', $post->ID);
                  $battery = get_field('battery', $post->ID);
                  $price = get_field('price', $post->ID);
                  $font = get_field('font', $post->ID);
                  $featured_img_url = get_field('featured_image', $post->ID);
                  $is_featured = (get_field('featured_post', $post->ID) == 'Yes') ? 'is-featured-post' : '';
               ?>
               <li class="phone" id="post-item-<?=$post->ID ?>">
                  <button id="featured-btn" type="button" class="featured-post <?=$is_featured;?>" onclick="is_Featured('<?=$post->ID;?>','<?=$is_featured;?>', this, '<?=$post->post_title;?>')" class="<?=$is_featured ? 'is-featured-post' : 'featured-post'?>"><i class="fa fa-heart"></i></button>
                  <a href="<?=get_permalink($post->ID) ?>"><div class="phone-img" style="background-image: url(<?=$featured_img_url ? $featured_img_url : get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div></a>
                  <div class="blog-content" style="background-image: url(<?=get_theme_file_uri('/images/polygonal-bg.jpg');?>); background-size: 200%; background-position: 43% 13%">
                     <h5 style="font-family: 'Kanit', sans-serif;"><?=get_the_title();?></h5><br>
                     <p class="spec-d"><span class="material-icons-outlined">memory</span> <?=$rom;?>GB ROM<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$ram;?>GB RAM<br><span class="material-icons-outlined">camera</span> <?=$rear; ?><br><span class="material-icons-outlined">developer_board</span> <?=$chipset;?><br><span class="material-icons-outlined">battery_4_bar</span>&nbsp;<?=$battery?><br><span class="material-icons-outlined">sell</span>&nbsp;PHP <?=number_format($price, 2, '.', ',');?></p>
                     
                     <div class="blog-actions">
                        <a href="javascript: ;" class="blog-ebtn" onclick="editPhone(<?=$post->ID?>)"><button type="button" ><i class="fa-regular fa-pen-to-square"></i></button></a>
                        <a href="javascript: ;" class="blog-dbtn" onclick="deletePost('<?=$post->ID?>', '<?=$post->post_title?>')"><button type="button"><i class="fa fa-trash"></i></button></a>
                     </div>
                  </div>
               </li>
            <?php } ?>
         </ul>

         <!-- Pagination -->
         <div class="pagination">
            <?php if(pagination($paged, $query->max_num_pages)){ ?>
               <div class="pagination-list">
                     <?=pagination($paged, $query->max_num_pages); ?>
               </div>
            <?php } ?>
         </div>
         

      </div>
   
   <!-- Error Message | Search not found -->
   <?php } else{ ?>
      <div class="custom-alert custom-alert-warning">
         <strong>Oops!</strong> The phone you're searching is not available.
      </div>
    <?php } ?>

   <!-- Post Modal -->
   <div id="postModal" class="modal">
      <div class="modal-content w3-animate-zoom">
         <!-- Modal Close Button -->
         <div id="modal_header" class="modal-header">
            <h6 class="modal-title" id="modal_title"> <i class="fa-sharp fa-solid fa-pen" style="margin-right: 10px;"></i> Create A New Post</h6>
            <span class="close" onclick="closeModal('postModal')">&times;</span>
         </div>
         
         <div class="waiting-loader d-none" id="post-loader"><i class="fa-sharp fa-solid fa-spin fa-spinner"></i> <span>Loading post. Please wait.</span></div>

         <div class="main-post-image" id="featured-img-view" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg')?>);"></div>
         <div id="post-form-wrapper" class="modal-form">
            <form id="form-id" action="javascript:;" method="post" class="form-container">
               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Brand</label>
                     <input type="text" name="brand" id="brand" class="form-input" placeholder="Brand" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Released</label>
                     <input type="date" name="released" id="released" class="form-input" value="" placeholder="Released" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Technology</label>
                     <input type="text" name="technology" id="technology" class="form-input" placeholder="Technology" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">SIM</label>
                     <input type="text" name="sim" id="sim" class="form-input" placeholder="SIM" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Size</label>
                     <input type="text" name="size" id="size" class="form-input" placeholder="Size" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Resolution</label>
                     <input type="text" name="resolution" id="resolution" class="form-input" placeholder="Resolution" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">OS</label>
                     <input type="text" name="os" id="os" class="form-input" placeholder="OS" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Chipset</label>
                     <input type="text" name="chipset" id="chipset" class="form-input" placeholder="Chipset" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">ROM (Internal Storage)</label>
                     <input type="number" name="rom" id="rom" class="form-input" placeholder="ROM" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">RAM</label>
                     <input type="number" name="ram" id="ram" class="form-input" placeholder="RAM" required>
                  </div>
               </div>
               
               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Camera Rear</label>
                     <input type="text" name="cam_rear" id="cam_rear" class="form-input" placeholder="Camera Rear pixels" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Camera Front</label>
                     <input type="text" name="cam_front" id="cam_front" class="form-input" placeholder="Camera Front pixels" required>
                  </div>
               </div>
               
               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Battery</label>
                     <input type="text" name="battery" id="battery" class="form-input" placeholder="Battery" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Model</label>
                     <input type="text" name="model" id="model" class="form-input" placeholder="Model" required>
                  </div>
               </div>

               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Price</label>
                     <input type="number" name="price" id="price" class="form-input" placeholder="Price" required>
                  </div>
               </div>

               <div class="form-wrapper" style="height: 75px;">
                  <label style="margin-left: 20px;" for="subject">Make it Featured?</label>
                  <div class="form-group">
                        <select name="featured_post" id="featured_post" class="featured-select">
                           <option value="No">No</option>
                           <option value="Yes">Yes</option>
                        </select>
                  </div>
               </div>
               <div class="form-wrapper">
                  <div class="form-group">
                     <label for="">Featured Image</label>
                     <input type="file" id="image" name="post_image" accept=".png, .jpg">
                     <input type="hidden" name="action" value="add_phone">
                     <input type="hidden" name="post_id" id="post_id" value="0">
                  </div>
               </div>
               <div class="form-wrapper">
                  <div class="form-group">
                     <button id="submitbtn" class="create" type="button" onclick="addPhone(this)">Submit</button>
                  </div>
               </div>
               
            </form>
         </div>
      </div>
   </div>

   <?php
   get_footer(); 
?>