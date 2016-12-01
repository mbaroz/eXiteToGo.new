<?
$json_str='{"topMenuContainerCode":"","mainContentContainer":"","mainContentClass":"main.wrap","topMenuContainerClass":"main_menu","ALTERNATE_MAIN_CONTENT_CLASS":["some","some2"]}';
print_r(json_decode($json_str,true));
die();
$a=array(
	array("name"=>"moshe","id"=>1),
	array("name"=>"yossi","id"=>2)
	);
$b=array(
	array("name"=>"ww","id"=>33),
	array("name"=>"qq","id"=>222)
	);
$c=array_merge($a,$b);
print_r($c);
die();
$s="1111|222";
$d=explode("|", $s);
print $d[0];
die();
?>

<style>
  .bubble {
    position: relative;
    min-width: 265px;
    max-width: 500px;
    min-height: 40px;
    padding: 10px;
    background: #efefef;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: 0px 3px 9px 0px rgba(97, 97, 97, 0.3);
    -moz-box-shadow: 0px 3px 9px 0px rgba(97, 97, 97, 0.3);
    box-shadow: 0px 3px 9px 0px rgba(97, 97, 97, 0.3);
}

  .bubble:after {
    content: "";
    position: absolute;
    top: 24px;
    right: -14;
    border-style: solid;
    border-width: 13px 0 13px 14px;
    border-color: transparent #efefef;
    display: block;
    width: 0;
    z-index: 1;
}

</style>
<div class="bubble">www.css3-generator.weebly.com</div>
<script>
var text = '{ "employees" : [' +
'{ "firstName":"משה" , "lastName":"בר עוז" },' +
'{ "firstName":"Anna" , "lastName":"Smith" },' +
'{ "firstName":"Peter" , "lastName":"Jones" } ]}';
var obj = JSON.parse(text);
</script>
<?

$a="Emek Refa'im 53 Apt. 21";

print htmlspecialchars($a,ENT_QUOTES);
?>
  <link href="https://api.motion.ai/sdk/webchat.css" rel="stylesheet" type="text/css">
  <script src="https://api.motion.ai/sdk/webchat.js"></script>
  <script>
  motionAI_Init('10137?color=62a8ea&sendBtn=SEND&inputBox=Type+something...&token=5de2344e648f330c8a1aec744df0162c',true,400,470); /* botID with access token, display bot icon?, modal width, modal height */
  /* you may also invoke motionAI_Open(); to manually open the modal */
  </script>
<?
die();
function IssueInvoice() {
	$description="eXite - בדיקה שלוש";
	$apiKey = "20fd3cabb76cd6d419253190340a85b4";
	$apiSecret = "2156d73820b480e4818102849c98bb6a"; 
	$params = array(
	    "timestamp" => time(), //Current timestamp
	    "callback_url" => "http://api.exite.co/paypal/gi.php",
	    "doc_type" => 320,
	    "description" => 'אתר טוגו',
	    "remarks"=>"TranIndex: 22222",
	    "client" => array(
	        "send_email" => true,
	        "name" => "משה בר עוז",
	        "tax_id" => "025605932",
	        "email" => array("mbaroz@gmail.com","moshe@exite.co.il"),
	        "address" => "-",
	        "city" => "",
	        "zip" => "",
	        "add"=>true
	    ),
	    "income" => array(
	        array(
	            "price" => 99.00,
	            "description" => $description
	        )
	    ),
	    "payment" => array(
	        array(
	            "type" => 3, //cc
	            "date" => date('Y-m-d'), //YYYY-MM-DD
	            "amount" => 99.00,
	            "card_type" => 2,
	            "deal_type"=>1
	        )
	    )
	);
	 
	//Compute hashed signature with SHA-256 algorithm and the secret key
	$params_encoded = json_encode($params);
	$signature = base64_encode(hash_hmac('sha256', $params_encoded, $apiSecret, true));
	 
	$data = array(
	    "apiKey" => $apiKey,
	    "params" => $params,
	    "sig" => $signature
	);
	 
	//Initializing curl
	$ch = curl_init();
	 
	//Configuring curl options
	$options = array(
	    CURLOPT_URL => "https://api.greeninvoice.co.il/api/documents/add",
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => "data=" . urlencode(json_encode($data)),
	    CURLOPT_SSL_VERIFYPEER => false,
	    CURLOPT_RETURNTRANSFER => true
	);
	 
	//Setting curl options
	curl_setopt_array($ch, $options);
	 
	//Getting results
	$result = curl_exec($ch); // Getting jSON result string
	curl_close($ch);
	$response = json_decode($result);
	 
	//If Ok
	if ($response->error_code == 0) {
	    return true;
	}
	else {
		//@file_put_contents('tranzila/tmp/gi_'.time(),print_r($response,true));
		return $response;
	}
}


die();
?>