$(function() {
    $( "#loginEmail" ).keyup(function() {
        var email = $("#loginEmail").val();
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
            $("#loginBtn").attr("disabled",false);
        }else{
            $("#loginBtn").attr("disabled",true);
        }
    });
   
});
function login(){
  var email = $("#loginEmail").val();
  $("#loginBtn").attr("disabled",false);
  $.ajax({
      method: "POST",
      url: "../actions/login.php",
      data: "email=" + email,
      success:function(response) {
          var jsonData = JSON.parse(response);
          if(jsonData.success == "1"){
              window.location.href = "loader.php?redirect=error";
          }
      }
  });
}