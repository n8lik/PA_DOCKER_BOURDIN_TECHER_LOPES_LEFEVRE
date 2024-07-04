<?PHP

session_start();


$_SESSION["booking"] = 1;
$id = $_SESSION["PaymentIntent"]["id"];
$type = $_SESSION["PaymentIntent"]["type"];

header("Location: /reservation/booking.php?id=$id&type=$type");
