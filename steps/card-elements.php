<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Credit Card Payment Form</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway|Rock+Salt|Source+Code+Pro:300,400,600" rel="stylesheet"><link rel="stylesheet" href="../assets/css/card2.css">

</head>
<body>

    <div class="form-container">
        <div class="field-container">
            <label for="name">Titulaire de la carte</label>
            <input id="name" maxlength="20" type="text">
        </div>
        <div class="field-container">
            <label for="cardnumber">Numéro de carte</label>
            <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric">
            <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">

            </svg>
        </div>
        <div class="field-container">
            <label for="expirationdate">Expiration (mm/yy)</label>
            <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric">
        </div>
        <div class="field-container">
            <label for="securitycode">Cryptogramme visuel</label>
            <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric">
        </div>
    </div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js'></script><script  src="../assets/js/card-elements1.js"></script>

</body>
</html>
