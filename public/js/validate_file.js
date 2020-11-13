$(function(){
    $('#file').change(function() {
    var fileSize = $('#file').prop('files')[0].size;
        if (fileSize > 8300000) {
          alert("ファイルが大き過ぎます。");
        //   console.log(fileSize);
          $('#file').val(null); 
        }
    });
});

