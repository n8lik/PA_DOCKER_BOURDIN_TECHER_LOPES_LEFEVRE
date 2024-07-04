<?php
//Pour ajouter un utilisateur dans la base de données
function createUser(string $pseudo, string $firstname, string $lastname, string $email, string $phone_number, string $extension, string $password, string $country, string $address, string $city, string $postal_code, string $grade)
{
    //On récupère la connexion à la base de données
    require_once __DIR__ . "/../../database/connection.php";
    //On prépare la requête
    
    $databaseConnection = connectDB();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (pseudo, firstname, lastname, email, phone_number, extension, password, country, address, city, postal_code, grade)
                    VALUES (:pseudo, :firstname, :lastname, :email, :phone_number, :extension, :password, :country, :address, :city, :postal_code, :grade)";
    $stmt = $databaseConnection->prepare($sql);
    $stmt->execute([
        'pseudo' => $pseudo,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'phone_number' => $phone_number,
        'extension' => $extension,
        'password' => $passwordHash,
        'country' => $country,
        'address' => $address,
        'city' => $city,
        'postal_code' => $postal_code,
        'grade' => $grade
    ]);
    echo "Point de contrôle 2";

    $databaseConnection = null;

}
