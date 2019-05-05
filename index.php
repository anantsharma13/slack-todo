
<?php
    // $data = '{"token":"Pg26RBOZMiKReK0XAfeomBl9","team_id":"TJG8FAN4X","team_domain":"dockablworkspace","channel_id":"CJECBEG5B","channel_name":"general","user_id":"UJ311BWCA","user_name":"anantsharma1310","command":"\/addtodo","text":"Dirty work","response_url":"https:\/\/hooks.slack.com\/commands\/TJG8FAN4X\/620137802817\/WoKcEZNUlAU2b7QRHnKvMHeJ","trigger_id":"628641446550.628287362167.09a793d6518acdd29b7e76c8a134adae"}';

    // $data = '{"token":"Pg26RBOZMiKReK0XAfeomBl9","team_id":"TJG8FAN4X","team_domain":"dockablworkspace","channel_id":"CJECBEG5B","channel_name":"general","user_id":"UJ311BWCA","user_name":"anantsharma1310","command":"\/listtodos","text":"","response_url":"https:\/\/hooks.slack.com\/commands\/TJG8FAN4X\/615148343059\/0s3phPQgw25uNhYFN85GzJWX","trigger_id":"615182193714.628287362167.787221edebb0e11b670c121f9e7fce3a"}';

    // $data = '{"token":"Pg26RBOZMiKReK0XAfeomBl9","team_id":"TJG8FAN4X","team_domain":"dockablworkspace","channel_id":"CJECBEG5B","channel_name":"general","user_id":"UJ311BWCA","user_name":"anantsharma1310","command":"\/marktodo","text":"\"Buy chocolate\"","response_url":"https:\/\/hooks.slack.com\/commands\/TJG8FAN4X\/626073814180\/3KLgK1PuGPDCEh1ZIUC7ATp6","trigger_id":"626073814212.628287362167.08c202ed7dfdc2f2c5266113ddc4a60a"}';

    // $data = json_decode($data,true);
    // print_r($data);
    // die;    
// https://api.slack.com/apps/AJ83KMB6  D
    // echo "hello world";
    // $data = json_encode($_POST);
    // file_put_contents(time().'.txt',$data);

    date_default_timezone_set('Asia/Kolkata');
    header('Content-Type: application/json');
    
    require_once('controller.php');
    $data = $_POST;
    $todo = new TODO($data);
    $response = $todo->executes();
    echo $response;
?>

