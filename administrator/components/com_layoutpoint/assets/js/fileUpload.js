(function(){
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('myfile');
    var uploadButton = document.getElementById('submit');
    var statusDiv = document.getElementById('status');

    form.onsubmit = function(event) {
        event.preventDefault();

        statusDiv.innerHTML = 'Uploading.......';

        // Get the files from the input
        var files = fileSelect.files;

        // Create a new FormData object.
        var formData = new FormData();

        //Grab just one file, since we are not allowing multiple file uploads
        var file = files[0]; 

        //Check the file type
        if (!file.type.match('excel.*')) {
            statusDiv.innerHTML = 'This file is not an image. Sorry, it cannot be uploaded. Try again with a valid image.';
            return;
        }

        if (file.size >= 2000000 ) {
            statusDiv.innerHTML = 'This file is larger than 2MB. Sorry, it cannot be uploaded.';
            return;
        }

         // Add the file to the request.
        formData.append('myfile', file, file.name);

        // Set up the AJAX request.
        var xhr = new XMLHttpRequest();

        // Open the connection.
        xhr.open('POST', 'index.php?option=com_layoutpoint&task=uploadfiles.upload', true);


        // Set up a handler for when the request finishes.
        xhr.onload = function () {
          if (xhr.status === 200) {
            statusDiv.innerHTML = 'The file uploaded successfully.......';
          } else {
            statusDiv.innerHTML = 'An error occurred while uploading the file. Try again';
          }
        };

        // Send the Data.
        xhr.send(formData);
    }
})();