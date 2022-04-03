
// Image upload and preview

window.onload = function() {
    if (window.File && window.FileList && window.FileReader) {
        $('.img-preview-upload').on("change", function(event,key) {
            var files = event.target.files;
            indexData  = $(this).attr('data-index');
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (!file.type.match('image'))
                    continue;
                var picReader = new FileReader();
                picReader.addEventListener("load", function(event) {
                    var picFile = event.target;
                    var div = document.createElement("div");
                    div.classList="me-2 mb-2";
                    div.innerHTML = "<img class='object-fit-cover' width='50px' height='50px' src='" + picFile.result + "'" +
                    "title='" + picFile.name + " '/>";
                    $('.output-img').eq(indexData).html(div).removeClass('d-none');
                });
                picReader.readAsDataURL(file);
            }
        });
    } else {
      console.log("Your browser does not support File API");
    }
}