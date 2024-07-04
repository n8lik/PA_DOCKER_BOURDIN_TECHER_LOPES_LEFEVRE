<?php
//On inclut les fichiers nécessaires    
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/login.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/createUser.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/token.php";

//On récupère le corps de la requête avec l'email et le mot de passe
$body = getBody();
$error = [];
$pseudo = $body["username"];
$firstname = $body["firstname"];
$lastname = $body["lastname"];
$email = $body["email"];
$phone_number = $body["phone_number"];
$extension = $body["extension"];
$password = $body["password"];
$passwordVerify = $body["passwordConfirm"];
$country = $body["country"];
$address = $body["address"];
$city = $body["city"];
$postal_code = $body["postal_code"];
$grade = $body["grade"];
/* $captcha = $body["g-recaptcha-response"];
 */

//Si il manque l'email on renvoie une erreur
if (!isset($body["email"])) {
    $error[] = "Email manquant";
}

//Si il manque le mot de passe on renvoie une erreur
if (!isset($body["password"])) {
    $error[] = "Mot de passe manquant";
}

//Si le format de l'email est incorrect on renvoie une erreur
if (!filter_var($body["email"], FILTER_VALIDATE_EMAIL)) {

    $error[] = "Format de l'email incorrect";
}

//Si le mot de passe et la vérification du mot de passe ne correspondent pas on renvoie une erreur

if ($body["password"] !== $body["passwordConfirm"]) {
    $error[] = "Les mots de passe ne correspondent pas";
}



//Si le mot de passe ne contient pas au moins 8 caractères on renvoie une erreur
if (strlen($body["password"]) < 8 || strlen($body["password"]) > 20 && !preg_match('/[A-Z]/', $body["password"]) && !preg_match('/[a-z]/', $body["password"]) && !preg_match('/[0-9]/', $body["password"])){

    $error[] = "Mot de passe  doit contenir entre 8 et 20 caractères, une majuscule, une minuscule et un chiffre";
}

//Si l'email est déjà utilisé on renvoie une erreur
if (getUserByEmail($body["email"])) {
    $error[] = "Email déjà utilisé";
}

if (strlen($body["username"]) < 2) {
    $error[] = "Pseudo trop court";
}
if (getUserByPseudo($body["username"])) {
    $error[] = "Pseudo déjà utilisé";
}

if (strlen($body["lastname"]) < 2) {
    $error[] = "Nom trop court";
}

if (strlen($body["firstname"]) < 2) {
    $error[] = "Prénom trop court";
}

if (!in_array($body["grade"], [1, 4, 5])) {
    $error[] = "Grade invalide";
}

if (!in_array($body["extension"], ["+33", "+32", "+41", "+1", "+44", "+49", "+34", "+39", "+31", "+30", "+90", "+91", "+92", "+93", "+94", "+95", "+96", "+97", "+98", "+99"])) {
    $error[] = "Extension invalide";
}

if (strlen($body["phone_number"]) < 10) {
    $error[] = "Numéro de téléphone trop court";
}

if (strlen($body["address"]) < 2) {
    $error[] = "Adresse trop courte";
}

if (strlen($body["city"]) < 2) {
    $error[] = "Ville trop courte";
}

if (strlen($body["postal_code"]) < 2) {
    $error[] = "Code postal trop court";
}

if (count($error)!=0) {
    echo jsonResponse(200, [],
        [
            "success" => false,
            "error" => $error
        ]);
    die();
}


createUser($pseudo, $firstname, $lastname, $email, $phone_number, $extension, $password, $country, $address, $city, $postal_code, $grade);
$id = getUserByEmail($email)["id"];
$token = generateToken($id);


echo jsonResponse(200, [], [
    "success" => true,
    "token" => $token,
    "grade" => $grade,
    "id" => $id


]);
