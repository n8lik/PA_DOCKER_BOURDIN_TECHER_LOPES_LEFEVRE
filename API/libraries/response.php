<?php

function jsonResponse($statusCode, $headers, $body)
{
    // Modifie le code de statut
    http_response_code($statusCode);

    // On modifie les en-têtes
    if (is_array($headers)) {
        foreach ($headers as $headerName => $headerValue) {
            header("$headerName: $headerValue");
        }
    }

    header("Content-Type: application/json");

    // On renvoie une réponse (contenu)
    return json_encode($body);
}
?>
