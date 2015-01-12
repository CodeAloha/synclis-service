<?php
	header("Content-Type: application/json");
	header('Access-Control-Allow-Origin: https://synclis.com');
	header('Access-Control-Allow-Origin: http://synclis.com');
	header('Access-Control-Allow-Origin: http://api.synclis.com');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	

	
    $method = $_SERVER['REQUEST_METHOD'];
    $args = $_SERVER['argv'];
    $file = Null;
	$args = explode('/', rtrim($request, '/'));
	if (array_key_exists(0, $args) && !is_numeric($args[0])) {
		$verb = array_shift($args);
	}
	
	switch($method) {
	case 'DELETE':
		$request = _cleanInputs($_GET);
		break;
	case 'POST':
		$request = _cleanInputs($_POST);
		break;
	case 'GET':
		$request = _cleanInputs($_GET);
		break;
	case 'PUT':
		$request = _cleanInputs($_GET);
		$file = file_get_contents("php://input");
		break;
	default:
		_response('Invalid Method', 405);
		break;
	}

	//HANDLE SESSION ID's
	if($request['session'] != ''){
		$u = mysqli_query($conn, "SELECT `USER_ID`, `EXPIRATION` FROM `AUTH_TOKEN` WHERE `HASH_KEY`='{$request['session']}'");
		$gainSessionId = mysqli_fetch_row($u);
		
		if(!$request['session']) die('{"response": "error","message": "No token provided."}'); 
		else if($gainSessionId[1] <= time()) die('{"response": "error","message": "You are not logged in."}');
		else $USER_ID = $gainSessionId[0];
	}
	
	function checkSession($conn, $session)
	{//For external checks
		if($session == ''){ return false; }
		$u = mysqli_query($conn, "SELECT `USER_ID`, `EXPIRATION` FROM `AUTH_TOKEN` WHERE `HASH_KEY`='{$session}'");
		$gainSessionId = mysqli_fetch_row($u);
		if($gainSessionId[1] <= time()) return false;
		else return $gainSessionId[0];
	}
	
	
    function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . _requestStatus($status));
        return json_encode($data);
    }

    function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = _cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }

?>