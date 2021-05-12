var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('logo_upload');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
