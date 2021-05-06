var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('animalView');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };

  var loadFilesnd = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('addressPreview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
