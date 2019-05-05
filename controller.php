<?php

require_once('model.php');

// $db = new DB();
// $result = $db->insert(array('u_id' => '121', 'ch_id' => 2121,'task' => 'Be smart', 'created_at' => '23232'),'todo');
// $result = $db->update(array('ch_id' => '4333'),array('u_id' => '121'),'todo');
// $result  = $db->fetchAll('todo');
// $result  = $db->fetch(array('created_at' => '23233' ),'todo');
// print_r($result);


class TODO  extends DB{

    private $db = null,$ch_id = null,$u_id = null,$command = null, $message = "", $model = 'todo';

    public function __construct($data){
        $this->db = new DB();
        $this->data = $data;
        $this->parseData();
    }

    // Executes function respective to command received
    public function executes(){
        $result = $this->{$this->command};
    }

    // List tasks
    public function __listtodos(){
            
        $whereArr = array('ch_id' => $this->ch_id);
        $result = $this->db->fetch($whereArr,$this->model);
        if($result){
            $responseMessage = "";
            foreach($result as $key => $value){
                $responseMessage .= '-'.$value['task']."\n"; 
            }
            $this->sendResponse($responseMessage);
        }else{
            $this->sendResponse('No TODOs');
        }
    }

    // add tasks
    public function addtodo(){

        $currentDate = date('d-m-Y H:i:s');
        $insertArr = array('u_id' => $this->u_id, 'ch_id' => $this->ch_id, 'task' => $this->message, 'created_at' => $currentDate);
        $result = $this->db->insert($insertArr,$this->model);
        if($result){
            $this->sendResponse(`Added TODO for "$this->message"`);
        }else{
            $this->handleErrors();
        }
    }

    // mark todo tasks
    public function marktodo(){
        $whereArr = array('task' => $this->message);
        $result = $this->db->remove($whereArr,$this->model);
        if($result){
            $this->sendResponse(`Removed TODO for "$this->message"`);
        }else{
            $this->handleErrors();
        }
    }

    public function sendResponse($msg){
        
        $responseArr = array('response_type' => 'in_channel', 'text' => $msg, 'attachments' => array('text'=> ''));
        $responseJson = json_encode($responseArr);
        return $responseJson;    
    }
    
    public function parseData(){

        if(!empty($this->data)){
            $this->ch_id = $this->data['ch_id'];
            $this->u_id = $this->data['u_id'];
            $this->message = $this->data['message'];
            $this->command = $this->data['command'];
            $this->checkParams();
        }else{
            $this->handleErrors();
        }
    }    

    public function checkParams(){
        
        if(empty($this->message) && ($this->command != "listtodos") ) {
            $this->handleErrors();
        }else{
            if(!in_array($this->command, array('listtodos','addtodo','marktodo'))){
                $this->handleErrors();
            }
        }
    }

    // Handle all errors
    public function handleErrors(){
        $this->sendResponse('Some error occured');
    }

} 


?>