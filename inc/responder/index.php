<?
	die();
	include 'OAuth.php';
	include 'responder_sdk.php';
	
	# Tokens; fill with the tokens acquired from the responder support team
	$client_key = 'C45B8EE35533B3E8371041C6BC4368ED';
	$client_secret = 'CD2FF2907BA9E2E80BF916D3606213E7';
	
	$user_key = '69FAB0B96662EDABDA04BD9F7871D185';
	$user_secret = 'BC1A2FD32ED3C03862B05519C7177B85';
	
	
	# create the responder request instance
	$responder = new ResponderOAuth($client_key, $client_secret, $user_key, $user_secret);
	
	# the data passed with the request (not needed with GET method)
	$post_data = array(
		'subscribers' => json_encode(
			array(
				array(
					'EMAIL' => 'moshew@exite.co.il',
					'NAME' => 'John Smith2',
					'PHONE'=>'052-2617079'
				)
			)
		)
	);
	
	# execute the request
	$response = $responder->http_request('lists/177533/subscribers', 'post', $post_data);
	$json_response = json_decode($response);
	echo '<pre>';
	
	# print the response
	if ($json_response) {
		print_r($json_response);
	} else {
		print_r($response);
	}
?>