<?php
require "conf.inc.php";
session_start(); // Démarrer la session au début


//Connection a la DB
function connectDB()
{
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        echo "Erreur SQL " . $e->getMessage();
        exit;
    }
}



//#########################################Users #########################################
function nbUserByGrade($grade){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE grade = ?");
    $req->execute([$grade]);
    //Récupérer le nombre d'utilisateurs ayant le grade passé en paramètre
    $count = $req->fetchColumn();
    return $count;
}

//afficher la liste des utilisateurs selon le grade
function getUsersByGrade($grade){
    $db = connectDB();
    if ($grade == "users"){
        $req = $db->prepare("SELECT * FROM user WHERE grade = 1 OR grade = 2 OR grade = 3");
        $req->execute();
        return $req->fetchAll();
    } else {
        $req = $db->prepare("SELECT * FROM user WHERE grade = ?");
        $req->execute([$grade]);
        return $req->fetchAll();
    }
}

function getUserById($id){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE id = ?");
    $req->execute([$id]);
    return $req->fetch();
}

//afficher le nombre total d'utilisateurs
function totalNbUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user");
    $req->execute();
    return $req->fetchColumn();
}

//afficher la liste de tous les utilisateurs
function getAllUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user");
    $req->execute();
    return $req->fetchAll();
}

//Supprimer un utilisateur (is_deleted=1)
function deleteUser($id){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET is_deleted = 1 WHERE id = ?");
    $req->execute([$id]);
}
//Afficher le nombre de nouveaux utilisateurs selon le mois (1,2,3,4,5,6,7,8,9,10,11,12)
function getNewUsersByMonth($month){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE MONTH(creation_date) = ?");
    $req->execute([$month]);
    return $req->fetchColumn();
}

function getGrade($grade){
    switch ($grade){
        case 1:
            return "Voyageur";
        case 2:
            return "Voyageur VIP1";
        case 3:
            return "Voyageur VIP2";
        case 4:
            return "Bailleur";
        case 5:
            return "Prestataire";
        case 6:
            return "Administrateur";
    }
}

//Fonction pour savoir si un utilisateur est validé ou non, ou pire: supprimé
function getUserStatus($id){
    $db = connectDB();
    //On verifie si l'user est supprimé
    $req = $db->prepare("SELECT is_deleted FROM user WHERE id = ?");
    $req->execute([$id]);
    $is_deleted = $req->fetchColumn();
    if ($is_deleted == 1){
        return "Supprimé";
    }
    //On verifie si l'user est validé
    $req = $db->prepare("SELECT is_validated FROM user WHERE id = ?");
    $req->execute([$id]);
    $is_validated = $req->fetchColumn();
    if ($is_validated == 1){
        return "Validé";
    }
    return "En attente de validation";
}

//Update un user
function updateUser($id, $pseudo, $firstname, $lastname, $email, $grade){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET pseudo = ?, firstname = ?, lastname = ?, email = ?, grade = ? WHERE id = ?");
    $req->execute([$pseudo, $firstname, $lastname, $email, $grade, $id]);
}

//Insérer un nouvel administrateur$_POST['pseudo'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pwd'], $_POST['pwdConfirm'], $_POST['grade']
function addNewAdmin($pseudo, $firstname, $lastname, $email, $password, $passwordConfirm){
    $errors=[];
    if (empty($pseudo) || empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($passwordConfirm)){
        $errors[] = "Veuillez remplir tous les champs";
    }elseif($password != $passwordConfirm){
        $errors[] = "Les mots de passe ne correspondent pas";
    }elseif (strlen($password) < 8){
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "L'adresse email n'est pas valide";
    }elseif (emailExists($email)){
        $errors[] = "L'adresse email est déjà utilisée";
    }elseif (pseudoExists($pseudo)){
        $errors[] = "Le pseudo est déjà utilisé";
    }
    if (count($errors)!= 0){
        return $errors;
    }else{
        $db = connectDB();
        $req = $db->prepare("INSERT INTO user (pseudo, firstname, lastname, email, password, grade, is_validated, is_admin) VALUES (?, ?, ?, ?, ?, 6, 1,1)");
        $req->execute([$pseudo, $firstname, $lastname, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
    return $errors;
}
//Réactiver un utilisateur
function reactivateUser($id){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET is_deleted = 0 WHERE id = ?");
    $req->execute([$id]);
}
//Validater un utilisateur
function validateUser($id){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET is_validated = 1 WHERE id = ?");
    $req->execute([$id]);
}
//Rechercher un utilisateur selon n'importe quel champ
function searchingBar($search,$choice){
    $db = connectDB();
    switch($choice){
        case "all":
            $req = $db->prepare("SELECT * FROM user WHERE pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "travelers":
            $req = $db->prepare("SELECT * FROM user WHERE (grade = 1 OR grade = 2 OR grade = 3) AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "landlords":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 4 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "providers":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 5 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "admins":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 6 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "housing":
            $req = $db->prepare("SELECT * FROM housing WHERE title LIKE ? OR address LIKE ? OR type_house LIKE ? or price LIKE ? or creation_date LIKE ?");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "performance":
            $req = $db->prepare("SELECT * FROM performances WHERE title LIKE ? OR address LIKE ? OR performance_type LIKE ? or price LIKE ? or creation_date LIKE ?");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "vlandlords":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 4 AND is_validated = 0 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "vproviders":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 5 AND is_validated = 0 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "vhousing":
            $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 0 AND (title LIKE ? OR address LIKE ? OR type_house LIKE ? or price LIKE ? or creation_date LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
        case "vperformance":
            $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 0 AND (title LIKE ? OR address LIKE ? OR performance_type LIKE ? or price LIKE ? or creation_date LIKE ?)");
            $req->execute(["%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%", "%".$search."%"]);
            return $req->fetchAll();
            
    }
}
//Verifier si un email existe déjà
function emailExists($email){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
    $req->execute([$email]);
    $count = $req->fetchColumn();
    return $count != 0;
}
//Verifier si un pseudo existe déjà
function pseudoExists($pseudo){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE pseudo = ?");
    $req->execute([$pseudo]);
    $count = $req->fetchColumn();
    return $count != 0;
}

//#########################################Pending #########################################
//Afficher la liste des utilisateur en attente de validation selon le grade passé en paramètre
function getPendingUsersByGrade($grade){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE grade = ? AND is_validated = 0");
    $req->execute([$grade]);
    return $req->fetchAll();
}

//Afficher la liste des utilisateur en attente de validation
function getAllPendingUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE is_validated = 0");
    $req->execute();
    return $req->fetchAll();
}
function nbAllPendingUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE is_validated = 0");
    $req->execute();
    return $req->fetchColumn();
}

//Afficher la liste des annonces en attente de validation
function getPendingAdsByType($type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 0");
    }else{
        $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 0");
    }
    $req->execute();
    return $req->fetchAll();
}


//Afficher la liste des annonces en attente de validation
function getAllPendingAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 0 UNION SELECT * FROM performances WHERE is_validated = 0");
    $req->execute();
    return $req->fetchAll();
}

function nbAllPendingAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM housing WHERE is_validated = 0 UNION SELECT COUNT(*) FROM performances WHERE is_validated = 0");
    $req->execute();
    return  $req->fetchColumn();
}
//##########################################Ads #########################################
//Afficher la liste des annonces (housing + performance tables)
function nbAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM housing UNION SELECT COUNT(*) FROM performances");
    $req->execute();
    $count = $req->fetchColumn();
    return $count;
}
function nbAdsByType($type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT COUNT(*) FROM housing");
    }elseif($type == "performance"){
        $req = $db->prepare("SELECT COUNT(*) FROM performances");
    }
    $req->execute();
    $count = $req->fetchColumn();
    return $count;
}

function nbPerformancesByCategory($category){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM performances WHERE performance_type = ?");
    $req->execute([$category]);
    $count = $req->fetchColumn();
    return $count;
}

function getAdsByCategory($category){
    $db = connectDB();
    if ($category == "housing"){
        $req = $db->prepare("SELECT * FROM housing");
    }else{
        $req = $db->prepare("SELECT * FROM performances");
    }
    $req->execute();
    return $req->fetchAll();
}

function getAdsById($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT * FROM housing WHERE id = ?");
    }else{
        $req = $db->prepare("SELECT * FROM performances WHERE id = ?");
    }
    $req->execute([$id]);
    return $req->fetch();
}

function deleteAd($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("UPDATE housing SET is_deleted = 1 WHERE id = ?");
    }else{
        $req = $db->prepare("UPDATE performances SET is_deleted = 1 WHERE id = ?");
    }
    $req->execute([$id]);
}

//pour verifier que l'annonce n'est ni supprimée ni validée
function getAdStatus ($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT is_deleted, is_validated FROM housing WHERE id = ?");
    }else{
        $req = $db->prepare("SELECT is_deleted, is_validated FROM performances WHERE id = ?");
    }
    $req->execute([$id]);
    $status = $req->fetch();
    if ($status['is_deleted'] == 1){
        return "Supprimée";
    }
    if ($status['is_validated'] == 0){
        return "En attente de validation";
    }
    return "Validée";
}



//Reactiver une annonce (is_deleted=0)
function reactivateAd($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("UPDATE housing SET is_deleted = 0 WHERE id = ?");
    }else{
        $req = $db->prepare("UPDATE performances SET is_deleted = 0 WHERE id = ?");
    }
    $req->execute([$id]);
}

//Valider une annonce (is_validated=1)
function validateAd($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("UPDATE housing SET is_validated = 1 WHERE id = ?");
    }else{
        $req = $db->prepare("UPDATE performances SET is_validated = 1 WHERE id = ?");
    }
    $req->execute([$id]);
}

//##########################Support################################
//Récuperer la table chatbot
function getChatbotMessages(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM chatbot");
    $req->execute();
    return $req->fetchAll();
}

//Modifier un message du chatbot
function editChatbotMessage($id, $keyword, $response){
    $db = connectDB();
    $req = $db->prepare("UPDATE chatbot SET keyword = ?, chatbotresponse = ? WHERE id = ?");
    $req->execute([$keyword, $response, $id]);
}

//Ajouter un message au chatbot
function addChatbotMessage($keyword, $response){
    $db = connectDB();
    //Verifier que ça n'existe pas déjà dans la table
    $verif= $db->prepare("SELECT COUNT(*) FROM chatbot WHERE keyword = ?");
    $verif->execute([$keyword]);
    $count = $verif->fetchColumn();
    if ($count != 0){
        return "Ce mot clé existe déjà";
    }
    //Sinon on l'ajoute
    $req = $db->prepare("INSERT INTO chatbot (keyword, chatbotresponse) VALUES (?, ?)");
    $req->execute([$keyword, $response]);
}
function deleteChatbotMessage($id){
    $db = connectDB();
    $req = $db->prepare("DELETE FROM chatbot WHERE id = ?");
    $req->execute([$id]);
}

function searchChatbotMessages($search){
    if (empty($search)){
        return getChatbotMessages();
    }
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM chatbot WHERE keyword LIKE ? OR chatbotresponse LIKE ?");
    $req->execute(["%".$search."%", "%".$search."%"]);
    return $req->fetchAll();
}

?>