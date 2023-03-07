<?php
   /*
      Template Name: Blog Template
   */ 
   get_header();  ?>

   <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/snow-mountain.jpg')?>)"></div>
      <div class="page-banner__content container container--narrow">
         <h1 class="blog-banner__title"><?php the_title(); ?></h1>
      </div>
   </div>

   <?php
   $args = array(
         'post_type'      => array('post'),
         'post_status'    => 'publish',
         'posts_per_page' => -1, // -1 is unlimited display, adding positive numbers will limit the display
         'orderby'        => 'date',
         'order'          => 'ASC',
   );
   $query = new WP_Query( $args );
   $posts = $query->posts;     
   ?>
   <?php if($posts) { ?>
      <div class="blog-wrapper">
         <button class="create" type="button" onclick="openPostForm()"><i style="margin-left: -8px;padding-right: 8px;" class="fa-sharp fa-solid fa-pen"></i>Create a new post</button>
         <ul>
            <?php foreach($posts as $post) { ?>
               <?php
                  $featured_img_url = get_field('featured_image', $post->ID);
                  $is_featured = (get_field('featured_post', $post->ID) == 'Yes') ? 'is-featured-post' : '';
               ?>
               <li id="post-item-<?=$post->ID ?>">
                  <button id="featured-btn" type="button" class="featured-post <?=$is_featured;?>" onclick="is_Featured('<?=$post->ID;?>','<?=$is_featured;?>', this, '<?=$post->post_title;?>')" class="<?=$is_featured ? 'is-featured-post' : 'featured-post'?>"><i class="fa fa-heart"></i></button>
                  <div class="blog-img" style="background-image: url(<?=$featured_img_url ? $featured_img_url : get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div>
                  <div class="blog-content">
                     <h5><a class="post-title" href="<?=get_permalink($post->ID) ?>" ><?=$post->post_title ?></a></h5>
                     <p class="blog-date"><?=get_the_author_meta( 'display_name', $post->post_author); ?><br><?=relative_date($post->post_date); ?></p>
                     <p class="blog-desc"><?=($post->post_content) ? ((strlen($post->post_content) <= 150) ? $post->post_content : substr(strip_tags($post->post_content), 0, 150).'...') : 'No Title'; ?></p>
                     <div class="blog-actions">
                        <a href="javascript: ;" class="blog-ebtn" onclick="editPost(<?=$post->ID?>)"><button type="button" ><i class="fa-regular fa-pen-to-square"></i></button></a>
                        <a href="javascript: ;" class="blog-dbtn" onclick="deletePost('<?=$post->ID?>', '<?=$post->post_title?>')"><button type="button"><i class="fa fa-trash"></i></button></a>
                     </div>
                  </div>
               </li>
            <?php } ?>
         </ul>
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
                        <label for="">Post Title</label>
                        <input type="text" name="post_title" id="post_title" class="form-input" placeholder="Post Title" required>
                     </div>
                  </div>
                  
                  <div class="form-wrapper">
                     <div class="form-group">
                        <label for="">Post Description</label>
                        <textarea name="post_description" id="post_description" cols="30" rows="10" class="form-input" placeholder="Type something..." required></textarea>
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
                        <label for="">Post Image</label>
                        <input type="file" id="image" name="post_image" accept=".png, .jpg">
                        <input type="hidden" name="action" value="create_post">
                        <input type="hidden" name="post_id" id="post_id" value="0">
                     </div>
                  </div>
                  <div class="form-wrapper">
                     <div class="form-group">
                        <button id="submitbtn" class="create" type="button" onclick="createPost(this)">Submit</button>
                     </div>
                  </div>
                  
               </form>
            </div>
            
         </div>
      </div>
   <?php
   get_footer(); 
?>