<?php


require '../includes/header.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/getConversation/' . $_SESSION["userId"]);
    $conversation = json_decode($response->getBody()->getContents(), true);
    
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

$conversations = [];
foreach ($conversation['privateMessages'] as $message) {
    if(isset($message['housing_id'])){
        $id = $message['housing_id'];
        $type = 'housing';
    } else {
        $id = $message['performance_id'];
        $type = 'performance';
    }   
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get($type == 'housing' ? '/getHousingAdsInfo/' . $id : '/getPerformanceAdsInfo/' . $id);
    $ad = json_decode($response->getBody()->getContents(), true)['adsInfo'];
    try {
        if ($_SESSION["userId"] == $message['to_user_id']){
            $response = $client->get('https://pcs-all.online:8000/users/' . $message["from_user_id"]);
            $user = json_decode($response->getBody(), true)['users'];

            $response = $client->get('https://pcs-all.online:8000/getPpById/' . $message["from_user_id"]);
        } else {
            $response = $client->get('https://pcs-all.online:8000/users/' . $message["to_user_id"]);
            $user = json_decode($response->getBody(), true)['users'];

            $response = $client->get('https://pcs-all.online:8000/getPpById/' . $message["to_user_id"]);
        }
        $userpdp = json_decode($response->getBody(), true)["users"];
        
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des informations</div>';
    }

    if (!isset($conversations[$message['id_conv']])) {
        $conversations[$message['id_conv']] = [
            'id_conv' => $message['id_conv'],
            'user' => $user,
            'userpdp' => $userpdp[0],
            'last_message' => $message['content'],
            'message_date' => $message['message_date'],
            'ads' => $ad['title'],
            'adsType' => $type,
            'adsId' => $id
        ];
    } else {
        // Mettre à jour avec le dernier message si le message actuel est plus récent
        if ($message['message_date'] > $conversations[$message['id_conv']]['message_date']) {
            $conversations[$message['id_conv']]['last_message'] = $message['content'];
            $conversations[$message['id_conv']]['message_date'] = $message['message_date'];
        }
    }

}
?>

<link rel="stylesheet" href="../css/conversation.css">

<div class="container">
        <h1>Mes Conversations</h1>
        <ul class="conversation-list">
            <?php foreach ($conversations as $conv): ?>
                <li class="conversation-item">
                    <div class="profile-picture">
                        <img src="<?= $conv['userpdp']; ?>" alt="Photo de profil">
                    </div>
                    <div class="conversation-details">
                        <span class ="ads-name"> Annonce : <a href="/ads?id=<?php echo $conv["adsId"];?>&type=<?php echo $conv['adsType'];?>"><?php echo $conv['ads'];?></a></span>
                        <span class="user-name"><?= htmlspecialchars($conv['user']['pseudo']);?></span>
                        <span class="last-message"><?= htmlspecialchars($conv['last_message']); ?></span>
                        <span class="message-date"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($conv['message_date']))); ?></span>
                    </div>
                    <a href="conversation.php?id=<?= htmlspecialchars($conv['id_conv']); ?>" class="conversation-link"></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>