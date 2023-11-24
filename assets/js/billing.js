$('#birthDate').keyup(function(){
    var nb_car = $(this).val().length;
    if(nb_car == 2 || nb_car == 5) {
        $(this).val($(this).val()+'/');
    }       
});

function billing(){
    $("#billingBtn").attr("disabled", true);
    $("#name").removeClass("input-error");
    $("#birthDate").removeClass("input-error");
    $("#address").removeClass("input-error");
    $("#zip").removeClass("input-error");
    $("#city").removeClass("input-error");
    $("#tel").removeClass("input-error");

    var hasError = 0;
        
    if($('#name').val().length == 0){
        $("#name").addClass("input-error");
        hasError = 1;
    }else if($('#name').val().match(/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/)){
        $("#name").addClass("input-error");
        hasError = 1;
    }

    if($('#birthDate').val().length == 0){
        $("#birthDate").addClass("input-error");
        hasError = 1;
    }else if(!$('#birthDate').val().match(/^(([1-2]\d|0[1-9]|[3][0-1])\/([0][1-9]|[1][0-2])\/[0-9]\d{3})$/)){
        $("#birthDate").addClass("input-error");
        hasError = 1;
    }
    if($('#address').val().length == 0){
        $("#address").addClass("input-error");
        hasError = 1;
    }
    if($('#zip').val().length == 0){
        $("#zip").addClass("input-error");
        hasError = 1;
    }else if(!$('#zip').val().match(/^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/)){
        $("#zip").addClass("input-error");
        hasError = 1;
    }
    if($('#city').val().length == 0){
        $("#city").addClass("input-error");
        hasError = 1;
    }
    if($('#tel').val().length < 10){
        $("#tel").addClass("input-error");
        hasError = 1;
    }
    if(!hasError){
        $.ajax({
            method: "POST",
            url: "../actions/billing.php",
            data: "name=" + $('#name').val() + "&birthDate=" + $('#birthDate').val() + "&address=" + $('#address').val() + "&zip=" + $('#zip').val() + "&city=" + $('#city').val() + "&tel=" + $('#tel').val(),
            success:function(response) {
                var jsonData = JSON.parse(response);
                if(jsonData.success == "1"){
                    window.location.href = "loader.php?redirect=card";
                }
            }
        });
    }else{
        $("#billingBtn").attr("disabled", false);
    }
};