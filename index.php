
<?php
    // $data = '{"token":"Pg26RBOZMiKReK0XAfeomBl9","team_id":"TJG8FAN4X","team_domain":"dockablworkspace","channel_id":"CJECBEG5B","channel_name":"general","user_id":"UJ311BWCA","user_name":"anantsharma1310","command":"\/addtodo","text":"Dirty work","response_url":"https:\/\/hooks.slack.com\/commands\/TJG8FAN4X\/620137802817\/WoKcEZNUlAU2b7QRHnKvMHeJ","trigger_id":"628641446550.628287362167.09a793d6518acdd29b7e76c8a134adae"}';

    // $data = json_decode($data,true);
    
// https://api.slack.com/apps/AJ83KMB6  D
    // echo "hello world";
    // $data = json_encode($_POST);
    // file_put_contents(time().'.txt',$data);

    require_once('controller.php');
    
    $data = $_POST;
    $todo = new TODO($data);
    $response = $todo->executes();
    echo $response;
?>

