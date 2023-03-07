<?php
    get_header();
    while(have_posts()) {
      the_post();
      $post_id = get_the_ID();
      $released = get_field('released', $post_id);
      $technology = get_field('technology', $post_id);
      $sim = get_field('sim', $post_id);
      $size = get_field('size', $post_id);
      $resolution = get_field('resolution', $post_id);
      $os = get_field('os', $post_id);
      $chipset = get_field('chipset', $post_id);
      $rom = get_field('rom', $post_id);
      $ram = get_field('ram', $post_id);
      $rear = get_field('camera_rear', $post_id);
      $front = get_field('camera_front', $post_id);
      $battery = get_field('battery', $post_id);
      $model = get_field('model', $post_id);
      $price = get_field('price', $post_id);
      $font = get_field('font', $post_id);
      $featured_img_url = get_field('featured_image', $post_id); ?>  
            
      <div class="phone-banner">
         <div class="phone-banner__bg-image" style="background-image: url(<?=get_theme_file_uri('/images/polygonal-bg.jpg'); ?>)"></div>
         <div class="phone-banner__content container pcontainer--narrow">
               <h1 class="phone-seller" >Xelfone's Gadgets</h1>
               <div class="parent-content">
                  <div class="phone-content">
                     <div style="width: 100%; display: flex; flex-direction: column;">
                        <div class="phone-wrapper">
                           <ul class="phone-items">
                              <li class="phone-item">
                                 <h3 class="phone-head-title" style="font-family: '<?=$font ;?>';"><?=get_the_title();?></h2>
                              </li>
                           </ul>
                        </div>  
                        <img class="phone-img" src="<?=$featured_img_url; ?>"></img>
                     </div>

                     <div class="specs">      
                        <table>
                           <tr class="spec">
                              <th colspan="3" >Phone Specifications</th>
                           </tr>

                           <tr class="spec">
                              <td class="title"><span class="material-icons-outlined">calendar_today</span>&nbsp;&nbsp;RELEASED</td>
                              <td id="date_released" style="border-radius: 0 12px 12px 0" colspan="2"><?=$released ?></td>
                           </tr>
                        
                           <tr class="spec">
                              <td class="title" rowspan="2"><span class="material-icons-outlined">public</span></i>&nbsp;&nbsp;NETWORK</td>
                              <td class="sub-title">Technology</td>
                              <td style="border-top-right-radius: 12px"><?=$technology?></td>
                           </tr>
                           <tr class="specc">
                              <td class="sub-title">SIM</td>
                              <td style="border-bottom-right-radius: 12px"><?=$sim;?></td>
                           </tr>

                           <!-- DISPLAY -->
                           <tr class="spec">
                           <td class="title" rowspan="2"><span class="material-icons-outlined">aspect_ratio</span>&nbsp;&nbsp;DISPLAY</td> 
                           <td class="sub-title">Size</td>
                           <td style="border-top-right-radius: 12px"><?=$size;?></td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Resolution</td>
                              <td style="border-bottom-right-radius: 12px"><?=$resolution;?></td>
                           </tr>
                           <!-- END OF DISPLAY -->

                           <!-- PLATFORM -->
                           <tr class="spec">
                              <td class="title" rowspan="3"><span class="material-icons-outlined">developer_board</span>&nbsp;&nbsp;PLATFORM</td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">OS</td>
                              <td style="border-top-right-radius: 12px"><?=$os;?></td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Chipset</td>
                              <td style="border-bottom-right-radius: 12px"><?=$chipset;?></td>
                           </tr>
                           <!-- END OF PLATFORM -->

                           <!-- MEMORY -->
                           <tr class="spec">
                              <td class="title" rowspan="3"><span class="material-icons-outlined">memory</span>&nbsp;&nbsp;MEMORY</td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">ROM</td>
                              <td style="border-top-right-radius: 12px"><?=$rom;?>GB</td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">RAM</td>
                              <td style="border-bottom-right-radius: 12px"><?=$ram;?>GB</td>
                           </tr class="spec">
                           <!-- END OF MEMORY -->

                           <!-- CAMERA -->
                           <tr class="spec">
                              <td class="title" rowspan="3"><span class="material-icons-outlined">camera</span>&nbsp;&nbsp;CAMERA</td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Rear</td>
                              <td style="border-top-right-radius: 12px"><?=$rear;?></td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Front</td>
                              <td style="border-bottom-right-radius: 12px"><?=$front;?></td>
                           </tr class="spec">
                           <!-- END OF CAMERA -->

                           <tr class="spec">
                              <td class="title"><span class="material-icons-outlined">battery_charging_full</span>&nbsp;&nbsp;BATTERY</td>
                              <td class="sub-title">Type</td>
                              <td style="border-radius: 0 15px 15px 0"><?=$battery;?></td>
                           </tr>


                           <!-- MISCELLANEOUS -->
                           <tr class="spec">
                              <td class="title" rowspan="3"><span class="material-icons-outlined">miscellaneous_services</span>&nbsp;&nbsp;MISC</td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Models</td>
                              <td style="border-top-right-radius: 12px;"><?=$model;?></td>
                           </tr>
                           <tr class="spec">
                              <td class="sub-title">Price</td>
                              <td style="border-bottom-right-radius: 12px;">PHP <?=number_format($price, 2, '.', ',');?></td>
                           </tr>
                           <!-- END OF MISCELLANEOUS -->

                           <!-- REFERENCE FROM GSMARENA -->
                        </table>
                     </div>
                  </div> 
               </div>
               <div class="page-banner__intro">
                  <p></p>
               </div>
         </div>
      </div>
    <?php }
    get_footer();
?>