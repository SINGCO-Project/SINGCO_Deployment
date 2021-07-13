//This JavaScript file is for the function of the upload modal in the main.php. It consists the drag and drop feature and the important elements such as submit button, divs (Drop fields and area), text area etc.  


var globalFunctions = {};

globalFunctions.ddInput = function(elem) {
  if ($(elem).length == 0 || typeof FileReader === "undefined") return;
  //getting the file
  var $fileupload = $('input[type="file"]');
  //Making List ul and li
  var noitems = '<li class="li no-items"><i class="fa fa-cloud-upload fa-3x cloud" aria-hidden="true"></i><br><span class="blue-text underline">Click to Browse </span> or Drop it Here</li>';
  //Submit button
  var btn='<input class="btn" type="submit" name="btnsubmit" value="Upload">';
  var file_list = '<ul class="ul file-list"></ul>';
  var rmv = '<div class="remove"><i class="fa fa-times"></i></div>';

  $fileupload.each(function() {
    var self = this;
   //The dropfield and droparea
    var $dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
    $(self).after($dropfield).appendTo($dropfield.find('.drop-area'));
    var $file_list = $(file_list).appendTo($dropfield);
    $(noitems).appendTo($file_list);
    var isDropped = false;
    $(self).on("change", function(evt) {
      if ($(self).val() == "") {
        $file_list.find('li').remove();
        $dropfield.removeClass('hover');
        $file_list.append(noitems);
      } else {
        if (!isDropped) {
             $dropfield.addClass('hover');
          $dropfield.addClass('loaded');
          var files = $(self).prop("files");
          traverseFiles(files);
        }
      }
    });

    $dropfield.on("dragleave", function(evt) {
      evt.stopPropagation();
    });

    $dropfield.on('click', function(evt) {
      $(self).val('');
      $file_list.find('li').remove();
      $file_list.append(noitems);
      $dropfield.removeClass('hover').removeClass('loaded');
    });
      
    //Hovering with a file
    $dropfield.on("dragenter", function(evt) {
      $dropfield.addClass('hover');
      evt.stopPropagation();
    });

    $dropfield.on("drop", function(evt) {
      isDropped = true;
      $dropfield.addClass('loaded');
      var files = evt.originalEvent.dataTransfer.files;
      traverseFiles(files);
      isDropped = false;
    });

     //Showing the Filename
    function appendFile(file) {
      console.log(file);
    // The file name
      $file_list.append('<li class="li remove">'+file.name + '</li>');
    }

    function traverseFiles(files) {
      if ($dropfield.hasClass('loaded')) {
        $file_list.find('li').remove();
      }
      if (typeof files !== "undefined") {
        for (var i = 0, l = files.length; i < l; i++) {
          appendFile(files[i]);
        }
      } else {
        alert("No support for the File API in this web browser");
      }
    }

  });
};

$(document).ready(function() {
  globalFunctions.ddInput('input[type="file"]');
});
