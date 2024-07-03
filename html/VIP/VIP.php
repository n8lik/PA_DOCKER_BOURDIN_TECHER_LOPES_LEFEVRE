<?php
    require '../includes/header.php';
    require '../vendor/autoload.php';
    if (!isConnected()){
        $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
        header("Location: /");
        die();
    }
    use GuzzleHttp\Client;
    $userToken = $_SESSION['token'];
    try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/usersbytoken/' . $userToken);
    $body = json_decode($response->getBody()->getContents(), true);
    $users = $body["users"];
} catch (Exception $e) {
    $users = [];
}
?>

<link href = "/css/VIP.css" rel="stylesheet">
<div class="container mt-5">

<?php 
echo $_SESSION["webhooks"];
if ($users["grade"] == 1){
    echo '<div class="alert alert-primary" role="alert">Vous êtes actuellement abonné au plan Free</div>';
}else if ($users["grade"] == 2){
    echo '<div class="alert alert-primary" role="alert">Vous êtes actuellement abonné au plan Bag Packer</div>';
}else if ($users["grade"] == 3){
    echo '<div class="alert alert-primary" role="alert">Vous êtes actuellement abonné au plan Explorator</div>';
}

try {
    $date = new DateTime($users["vip_date"]);
    $date->modify('+1 year');
    $date = $date->format('d/m/Y');

} catch (Exception $e) {
    echo 'Erreur : ', $e->getMessage();
}
if($users["vip_status"]==2){
    echo '<div class="alert alert-primary" role="alert">Votre abonnement a bien été arrêté. Vous pouvez en profiter jusqu\'à '. $date.' </div>';
}

if (isset($_SESSION["success"])){
    echo '<div class="alert alert-success" role="alert">'.$_SESSION["success"].'</div>';
    unset($_SESSION["success"]);
} ?>
<?php if (isset($_SESSION["error"])){
    echo '<div class="alert alert-danger" role="alert">'.$_SESSION["error"].'</div>';
    unset($_SESSION["error"]);
} ?>
<div class="table-responsive">
    <table class="table table-bordered table-custom">
        <thead>
            <tr>
                <th></th>
                <th>
                    <img src="/assets/img/VIP/free.png" alt="Free" class="icon"><br>
                    <p class="plan-title">Free</p>
                    <p>Gratuit</p>
                </th>
                <th>
                    <img src="/assets/img/VIP/backpacker.png" alt="Bag Packer" class="icon"><br>
                    <p class="plan-title">Bag Packer</p>
                    <?php if ($users["grade"] !=2){
                                                    $priceBag = 113;?>
                    <p>9,90€/mois ou 113€/an</p>
                    <?php  }else if($users["grade"]==2){
                                                    $priceBag = 102;?>
                    <p>9,90€/mois ou 102€/an</p>
                    <?php }?> 
                </th>
                <th>
                    <img src="/assets/img/VIP/explorateur.png" alt="Explorator" class="icon"><br>
                    <p class="plan-title">Explorator</p>
                    <?php if ($users["grade"]!=3){
                        $priceExplo = 220;?>
                    <p>19€/mois ou 220€/an</p>
                    <?php  }else if($users["grade"]==3){
                        $priceExplo = 200;?>
                    <p>19€/mois ou 200€/an</p>
                    <?php }?> 
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Présence de publicités dans le contenu consulté</td>
                <td class="check-icon">✔</td>
                <td class="cross-icon">✘</td>
                <td class="cross-icon">✘</td>
            </tr>
            <tr>
                <td>Commenter, publier des avis</td>
                <td class="cross-icon">✘</td>
                <td class="check-icon">✔</td>
                <td class="check-icon">✔</td>
            </tr>
            <tr>
                <td>Réduction permanente de 5% sur les prestations</td>
                <td class="cross-icon">✘</td>
                <td class="check-icon">✔</td>
                <td class="check-icon">✔</td>
            </tr>
            <tr>
                <td>Prestations offertes</td>
                <td class="cross-icon">✘</td>
                <td class="check-icon">✔<br>1 par an dans la limite d'une prestation d'un montant inférieur à 80€</td>
                <td class="check-icon">✔<br>1 par semestre, sans limitation du montant</td>
            </tr>
            <tr>
                <td>Accès prioritaire à certaines prestations et aux prestations VIP</td>
                <td class="cross-icon">✘</td>
                <td class="cross-icon">✘</td>
                <td class="check-icon">✔</td>
            </tr>
            <tr>
                <td>Bonus renouvellement de l'abonnement</td>
                <td class="cross-icon">✘</td>
                <td class="cross-icon">✘</td>
                <td class="check-icon">✔<br>Réduction de 10% du montant de l'abonnement en cas de renouvellement, valable uniquement sur le tarif annuel</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    
                </td>
                <td> 
                <?php if ($users["grade"]==3){
                            }else if ($users["grade"] != 2){?>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="1">
                            <input type="hidden" name="price" value ="9.90">
                            <button type="submit" class="btn btn-primary">Choisir Bag Packer Mensuel</button>
                        </form>
                        <br>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="2">
                            <input type="hidden" name="price" value ="<?php echo $priceBag;?>">
                            <button type="submit" class="btn btn-primary">Choisir Bag Packer Annuel</button>
                        </form>
                        
                        <?php }else { ?>
                            <form method="POST" action="/VIP/VIPDelete">
                            <button type="submit" class="btn btn-danger">Supprimer l'abonnement</button>
                        </form>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($users["grade"]==2){
                            }else if ($users["grade"] != 3){?>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="3">
                            <input type="hidden" name="price" value ="19">
                            <button type="submit" class="btn btn-primary">Choisir Explorator Mensuel</button>
                        </form>
                        <br>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="4">
                            <input type="hidden" name="price" value ="<?php echo $priceExplo;?>">
                            <button type="submit" class="btn btn-primary">Choisir Explorator Annuel</button>
                        </form>
                        <?php }else{?>
                            <form method="POST" action="/VIP/VIPDelete">
                            <button type="submit" class="btn btn-danger">Supprimer l'abonnement</button>
                        </form>
                        <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>


<?php include '../includes/footer.php'; ?>