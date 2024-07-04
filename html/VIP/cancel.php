<?PHP

session_start();


$test = $_SESSION["PaymentIntent"];
$id = $test["id"];
$type = $test["type"];

$_SESSION["error"] = "Votre paiement a été annulé";


header("Location: /VIP/VIP");
