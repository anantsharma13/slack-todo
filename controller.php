<?php

require_once('model.php');

// TODO Class controls/executes all todo app operations 

class TODO {

    private $db = null,$ch_id = null,$u_id = null,$command = null, $message = "", $model = 'todo'; // since there is only one schema 'todo'

    // Initialize instance of DB class and create db connection, parse input data (with validations) 
    public function __construct($data){
        $this->db = new DB();
        if($this->db->getConnection() == false){
            $this->handleErrors('Unfortunately, TODO app has stopped working.');
        }
        $this->data = $data;
        $this->parseData(); // parse input data with Error handling
    }

    // Executes function with respect to slack command
    public function executes(){
       return $this->{substr($this->command,1)}();
    }

    // get list of all TODOs in a channel
    public function listtodos(){
            
        $whereArr = array('ch_id' => $this->ch_id);
        $result = $this->db->fetch($whereArr,$this->model);
        if($result){
            $responseMessage = "";
            foreach($result as $key => $value){
                $responseMessage .= ' - '.$value['task']."\n"; 
            }
            return $this->sendResponse($responseMessage);
        }else{
            return $this->sendResponse('No TODOs');
        }
    }

    // Add a TODO task to a channel
    public function addtodo(){
       
        $currentDate = date('d-m-Y H:i:s');
        $insertArr = array('u_id' => $this->u_id, 'ch_id' => $this->ch_id, 'task' => $this->message, 'created_at' => $currentDate);
        $result = $this->db->insert($insertArr,$this->model);
        if($result){     
            return $this->sendResponse('Added TODO for "'.$this->message.'"');
        }else{
            $this->handleErrors('Failed to add TODO "'.$this->message.'"');
        }
    }

    // Remove a TODO task from a channel
    public function marktodo(){
        $this->message = str_replace('"',"",$this->message);
        $whereArr = array('task' => $this->message, 'ch_id' => $this->ch_id);
        $result = $this->db->remove($whereArr,$this->model);
        if($result){
            return $this->sendResponse('Removed TODO for "'.$this->message.'"');
        }else{
            $this->handleErrors('TODO task "'.$this->message.'" does not exist.');
        }
    }

    // Generate appropriate response JSON for a slack server
    // "in_channel" means response text will be visible to every member in a channel
    public function sendResponse($msg){
        $responseArr = array('response_type' => 'in_channel', 'text' => $msg, 'attachments' => array('text'=> ''));
        $responseJson = json_encode($responseArr);
        return $responseJson;    
    }
    
    // Parse input data and check if empty 
    // Perform error handling for invalid data
    public function parseData(){

        if(!empty($this->data)){
            $this->ch_id = $this->data['channel_id'];
            $this->u_id = $this->data['user_id'];
            $this->message = $this->data['text'];
            $this->command = $this->data['command'];
            $this->checkParams();
        }else{
            $this->handleErrors("We didn't receive any data, try again.");
        }
    }    

    // check if data is valid 
    public function checkParams(){
        
        if(empty($this->message) && ($this->command != "/listtodos") ) {
            $this->handleErrors('Please mention the TODO task.');
        }else{
            if(!in_array($this->command, array('/listtodos','/addtodo','/marktodo'))){
                $this->handleErrors('Invalid slash command.');
            }
        }
    }

    // Handle all errors and send appropriate error message to the slack server
    public function handleErrors($error_msg){
        echo $this->sendResponse($error_msg);
        die;
    }

} 


?>