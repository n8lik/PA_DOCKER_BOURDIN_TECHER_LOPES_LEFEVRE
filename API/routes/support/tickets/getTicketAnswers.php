<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../entities/support.php";

$parameters=getParametersForRoute("/getTicketAnswers/:id");
$id=$parameters["id"];

$answers=getTicketAnswers($id);

if(empty($answers))
{
    echo(jsonResponse(404,[],[
        "success"=>false,
        "message"=>"No answer found"
    ]));
}
else
{
    echo(jsonResponse(200,[],[
        "success"=>true,
        "answers"=>$answers
    ]));
}
?>