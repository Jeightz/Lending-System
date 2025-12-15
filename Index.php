<?php
$result = null;
$monthlypayment= 0;
if($_SERVER["REQUEST_METHOD"] == "POST"){
 $amount = $_POST['valueBorrow'];
 $month = $_POST['monthToPay'];

if ($amount < 500 || $amount > 50000) {
        $error = "Loan amount must be between ₱500 and ₱50,000";
}else{

$anuallyinterest = 0.50;
$monthlyrate  = $anuallyinterest / 12;
$monthlypayment = ($monthlyrate * $amount)/(1-(1+$monthlyrate)**(-$month));//Amortized loan

$result= [
  "monthly_interest" =>number_format($amount * $monthlyrate,2),
  "total_interest" => number_format(($monthlypayment * $month)- $amount ,2),
  "total_amount_to_pay" => number_format(($monthlypayment * $month),2),
  "payment_per_month" => number_format($monthlypayment,2) 
];
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel = "stylesheet" href ="assest/style.css">
</head>
<body>
  <div id="parent-container">
  <form method="POST">
  <div id= "child-container">
      <h1 class ="header">💰 Leanding System</h1>
      <input name ="valueBorrow" class = "input" type = "number" min = "500" max = "50000" step =1 placeholder="Please Input Value of Leading Money(500-50000)" require>
      <select  name ="monthToPay"class ="input"require>
        <option value="1">1 month</option>
        <option value="3">3 month</option>
        <option value="6">6 month</option>
        <option value="9">9 month</option>
        <option value="12">12 month</option>  
        <option value="24">24 month</option>
      </select>
      <button class = "btnlend">Lend Money</button>
    <?php if (isset($error)): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($result): ?>
      <div class="resultbox">
        <h1 class= "header">Loan Recipt</h1>
        <p><strong>Monthly Interest:</strong> ₱<?= $result["monthly_interest"]?></p>
        <p><strong>Total Interest:</strong> ₱<?= $result["total_interest"] ?></p>
        <p><strong>Total Amount to Pay:</strong> ₱<?= $result["total_amount_to_pay"] ?></p>
        <p><strong>Payment per Month:</strong> ₱<?= $result["payment_per_month"]?></p>
      </div>
    <?php endif; ?>
    </div>
  </form>
  </div>
</body>
</html>