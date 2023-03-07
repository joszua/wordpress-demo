var close; // used for closing modal
function openModal(modalID) {
  var modal = document.getElementById(modalID);
  modal.style.display = "block";
  close = modal;
}

function closeModal() {
  close.style.display = "none";
}

window.onclick = function (event) {
  if (event.target == close) {
    close.style.display = "none";
  }
}

function openPostForm() {
  $("#post-loader").addClass("d-none");
  $("#featured-img-view").removeClass("d-none");
  $("#post-form-wrapper").removeClass("d-none");
  openModal("postModal");

  $("#submitbtn").removeClass();
  $("#submitbtn").addClass("create");
  $("#modal_header").removeClass();
  $("#modal_header").addClass("modal-header");
  $("#submitbtn").html('<i class="fa-sharp fa-solid fa-pen"></i> Submit');
  $("#modal_title").html('<i class="fa-sharp fa-solid fa-pen"></i> Create a New Post');

  $("#post_id").val(0);
  $("#form-id")[0].reset();
  $('#featured-img-view').css('background-image', `uri('/wp-content/themes/newthemedemo/images/library-hero.jpg')`);
}

function createPost(e) {
  if ($("#post_title").val() && $("#post_description").val()) {
    $(e).html(
      '<i class="fa-sharp fa-solid fa-spin fa-spinner"></i> Posting...'
    );
    $(e).attr("disabled", "disabled");
    var formData = new FormData(document.getElementById("form-id"));
    $.ajax({
      type: "POST",
      url: $("#ajaxUrl").val(), // Target the function name to the WordPress. Ex: "get_create_posts_form_example"
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        var res = JSON.parse(response.slice(0, -1)); // We need this code to remove the number 1 on the return
        if (res.status == true) {
          swal(
            {
              title: "Post Saved",
              text: res.msg,
              type: "success",
            },
            () => {
              window.location.href = "/post-blogs";
            }
          );
          // console.log(res.data);
        } else {
          swal("New Post", "Create Post Failed.", "error");
        }
      },
      error: (e) => {
        console.log(e);
        swal("New Post", "Create Post Failed.", "error");
      },
    });
  } else {
    swal("Oops!", "Please input title and/or description!", "error");
  }
}

function addPhone(e) {
  if (
    $("#brand").val() &&
    $("#released").val() &&
    $("#technology").val() &&
    $("#sim").val() &&
    $("#size").val() &&
    $("#resolution").val() &&
    $("#os").val() &&
    $("#chipset").val() &&
    $("#rom").val() &&
    $("#ram").val() &&
    $("#cam_rear").val() &&
    $("#cam_front").val() &&
    $("#battery").val() &&
    $("#model").val() &&
    $("#price").val()
  ) {
    $(e).html('<i class="fa-sharp fa-solid fa-spin fa-spinner"></i> Adding...');
    $(e).attr("disabled", "disabled");
    var formData = new FormData(document.getElementById("form-id"));
    $.ajax({
      type: "POST",
      url: $("#ajaxUrl").val(),
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        var res = JSON.parse(response.slice(0, -1));
        if (res.status == true) {
          swal(
            {
              title: "Phone Saved",
              text: res.msg,
              type: "success",
            },
            () => {
              // window.location.href = "/phone-list";
            }
          );
          // console.log(res.data);
        } else {
          swal("Error", "Add Phone Failed.", "error");
        }
      },
      error: (e) => {
        console.log(e);
        swal("Error", "Add Phone Failed.", "error");
      },
    });
    // swal("Yikes!", "Phone added!", "success");
  } else {
    swal("Oops!", "Please input all required fields!", "error");
  }
}

function editPost(id) {
  openModal("postModal");
  $("#post-loader").removeClass("d-none");
  $("#featured-img-view").addClass("d-none");
  $("#post-form-wrapper").addClass("d-none");

  $("#modal_header").removeClass();
  $("#modal_header").addClass("modal-header-e");
  $("#submitbtn").html('<i class="fa-regular fa-pen-to-square"></i> Update');
  $("#modal_title").html('<i class="fa-regular fa-pen-to-square" style="margin-right: 10px;"></i> Edit Post');

  $.ajax({
    type: "POST",
    url: $("#ajaxUrl").val(),
    data: {
      post_id: id,
      action: "fetch_post",
    },
    success: (resp) => {
      var res = JSON.parse(resp.slice(0, -1));
      if (res.status == true) {
        console.log(res.data);

        // Update Field Values
        $("#post_id").val(res.data.post_id);
        $("#post_title").val(res.data.post_title);
        $("#post_description").val(res.data.post_description);
        $("#featured_post").val(res.data.featured_post);
        $("#featured-img-view").css("background-image", `url(${res.data.featured_image})`);

        // Hide Loader and show the forms
        $("#post-loader").addClass("d-none");
        $("#featured-img-view").removeClass("d-none");
        $("#post-form-wrapper").removeClass("d-none");
        $("#submitbtn").removeClass();
        $("#submitbtn").addClass("blog-ebtn");
      } else {
        // Error message
        toastr.error(
          "We found out that you have an issue with your system"
        );
      }
    },
    error: (e) => {
      toastr.error("We found out that you have an issue with your system");
    },
  }); 
}

function editPhone(id) {
  openModal("postModal");
  $("#post-loader").removeClass("d-none");
  $("#featured-img-view").addClass("d-none");
  $("#post-form-wrapper").addClass("d-none");

  $("#modal_header").removeClass();
  $("#modal_header").addClass("modal-header-e");
  $("#submitbtn").html('<i class="fa-regular fa-pen-to-square"></i> Update');
  $("#modal_title").html(
    '<i class="fa-regular fa-pen-to-square" style="margin-right: 10px;"></i> Edit Post'
  );

  $.ajax({
    type: "POST",
    url: $("#ajaxUrl").val(),
    data: {
      post_id: id,
      action: "fetch_phone",
    },
    success: (resp) => {
      var res = JSON.parse(resp.slice(0, -1));
      if (res.status == true) {
        console.log(res.data);

        // Update Field Values
        $("#post_id").val(res.data.post_id);
        $("#brand").val(res.data.brand);
        $("#released").val(res.data.released);
        $("#technology").val(res.data.technology);
        $("#sim").val(res.data.sim);
        $("#size").val(res.data.size);
        $("#resolution").val(res.data.resolution);
        $("#os").val(res.data.os);
        $("#chipset").val(res.data.chipset);
        $("#rom").val(res.data.rom);
        $("#ram").val(res.data.ram);
        $("#cam_rear").val(res.data.cam_rear);
        $("#cam_front").val(res.data.cam_front);
        $("#battery").val(res.data.battery);
        $("#model").val(res.data.model);
        $("#price").val(res.data.price);
        $("#featured-img-view").css(
          "background-image",
          `url(${res.data.featured_image})`
        );

        // Hide Loader and show the forms
        $("#post-loader").addClass("d-none");
        $("#featured-img-view").removeClass("d-none");
        $("#post-form-wrapper").removeClass("d-none");
        $("#submitbtn").removeClass();
        $("#submitbtn").addClass("blog-ebtn");
      } else {
        // Error message
        toastr.error("We found out that you have an issue with your system");
      }
    },
    error: (e) => {
      toastr.error("We found out that you have an issue with your system");
    },
  });
}

function updatePost(e) { // for edit
  if ($("#post_title").val() && $("#post_description").val()) {
    $(e).html(
      '<i class="fa-sharp fa-solid fa-spin fa-spinner"></i> Posting...'
    );
    $(e).attr("disabled", "disabled");
    var formData = new FormData(document.getElementById("form-id"));
    $.ajax({
      type: "POST",
      url: $("#ajaxUrl").val(), // Target the function name to the WordPress. Ex: "get_create_posts_form_example"
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        var res = JSON.parse(response.slice(0, -1)); // We need this code to remove the number 1 on the return
        if (res.status == true) {
          swal(
            {
              title: "New Post Added",
              text: res.msg,
              type: "success",
            },
            () => {
              window.location.href = "/post-blogs";
            }
          );
          // console.log(res.data);
        } else {
          swal("New Post", "Create Post Failed.", "error");
        }
      },
      error: (e) => {
        console.log(e);
        swal("New Post", "Create Post Failed.", "error");
      },
    });
  } else {
    swal("Oops!", "Please input title and/or description!", "error");
  }
}

function deletePost(id, postTitle) {
  swal(
    {
      title: `Delete "${postTitle}" post?`,
      text: "Please note, you will not be able to recover this. Continue?",
      type: "warning",
      showCancelButton: true,
      showLoaderOnConfirm: true,
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false,
      confirmButtonColor: "#e11641",
    },
    () => {
      $.ajax({
        type: "POST",
        url: $("#ajaxUrl").val(), // Target the function name to the WordPress. Ex: "get_create_posts_form_example"
        // data: $('#post-form').serialize(),
        // data: {
        //     post_title: $('#post_title').val(),
        //     post_description: $('#post_description').val(),
        // },
        data: {
          post_id: id,
          action: "delete_post",
        },
        success: (resp) => {
          var res = JSON.parse(resp.slice(0, -1)); // We need this code to remoge the number 1 on the return
          if (res.status == true) {
            swal("Deleted", "Successfully deleted.", "success");
            $("#post-item-" + id).remove(); //Deletes a list item based on the post id that is deleted
            // console.log(res.data);
          } else {
            swal("Delete", "Deletion Failed.", "error");
          }
        },
        error: (e) => {
          console.log(e);
        },
      });
    }
  );
}

function is_Featured(id, isFeatured, e, title) {
  $.ajax({
    type: "POST",
    url: $("#ajaxUrl").val(),

    data: {
      post_id: id,
      featured_post: ((isFeatured == "is-featured-post") ? 'No' : 'Yes'),
      action: "mod_feature",
    },
    
    success: (resp) => {
      var res = JSON.parse(resp.slice(0, -1));
      if (res.status == true) {
        if(isFeatured == 'is-featured-post') {
            toastr.success(`Removed as featured`);
            $(e).removeClass('is-featured-post');
            $(e).attr('onclick', `is_Featured(${id}, '', this)`);
        } else {
            toastr.success(`${title} is set as featured`);
            $(e).addClass('is-featured-post');
            $(e).attr('onclick', `is_Featured(${id}, 'is-featured-post', this)`); 
        }
      } else {
        toastr.error("An error occurred.");
      }
  },
    error: (e) => {
      console.log(e);
    }
  });
}
