<?php

// --------
// SETTINGS
// --------
$version = 95606;
$node    = array('127.0.0.1', 58272); // node you want to connect to
$local   = array('127.0.0.1', 58272); // our ip and port

list($node_ip, $node_port) = $node;
list($local_ip, $local_port) = $local;

//echo "\nNode\n----\n";
//echo 'version: ' . $version . PHP_EOL;
//echo 'node:    ' . implode($node, ':') . PHP_EOL;
//echo 'local:   ' . implode($local, ':') . PHP_EOL . PHP_EOL;


// ------------------
// 1. VERSION MESSAGE
// ------------------

// General Functions
function fieldsize($field, $bytes = 1)
{
	$length = $bytes * 2;
	$result = str_pad($field, $length, '0', STR_PAD_LEFT);
	return $result;
}

function swapEndian($hex)
{
	return implode('', array_reverse(str_split($hex, 2)));
}

function byteSpaces($bytes)
{ // add spaces between bytes
	$bytes = implode(str_split(strtoupper($bytes), 2), ' ');
	return $bytes;
}

// Version Message Functions
function timestamp($time)
{ // convert timestamp to network byte order
	$time = dechex($time);
	$time = fieldsize($time, 8);
	$time = swapEndian($time);
	return byteSpaces($time);
}

function networkaddress($ip, $port = '8333')
{ // convert ip address to network byte order
	$services = '01 00 00 00 00 00 00 00'; // 1 = NODE_NETWORK

	$ipv6_prefix = '00 00 00 00 00 00 00 00 00 00 FF FF';

	$ip = explode('.', $ip);
	$ip = array_map("dechex", $ip);
	$ip = array_map("fieldsize", $ip);
	$ip = array_map("strtoupper", $ip);
	$ip = implode($ip, ' ');

	$port = dechex($port); // for some fucking reason this is big-endian
	$port = byteSpaces($port);

	return "$services $ipv6_prefix $ip $port";
}

function checksum($string)
{
	$string   = hex2bin($string);
	$hash     = hash('sha256', hash('sha256', $string, true));
	$checksum = substr($hash, 0, 8);
	return byteSpaces($checksum);
}


// MAKE MESSAGES

function makeMessage($payload)
{

	// Header
	$magicbytes   = 'C4 E1 D8 EC';
	$command      = '76 65 72 73 69 6F 6E 00 00 00 00 00';
	$payload_size = bytespaces(swapEndian(fieldsize(dechex(strlen($payload) / 2), 4)));
	$checksum     = checksum($payload);

	$header_array = [
		'magicbytes'   => $magicbytes,
		'command'      => $command,
		'payload_size' => $payload_size,
		'checksum'     => $checksum,
	];

	$header = str_replace(' ', '', implode($header_array));
//	echo 'Header: ';
//	print_r($header_array);

	return $header . $payload;

}

function makeVersionPayload($version, $node_ip, $node_port, $local_ip, $local_port)
{

	// settings
	$services     = '01 00 00 00 00 00 00 00'; // (1 = NODE_NETORK)
	$user_agent   = '00';
	$start_height = 0;

	// prepare
	$version      = bytespaces(swapEndian(fieldsize(dechex($version), 4)));
	$timestamp    = timestamp(time()); // 73 43 c9 57 00 00 00 00
	$recv         = networkaddress($node_ip, $node_port);
	$from         = networkaddress($local_ip, $local_port);
	$nonce        = bytespaces(swapEndian(fieldsize(dechex(mt_rand()), 8)));
	$start_height = bytespaces(swapEndian(fieldsize(dechex($start_height), 4)));

	$version_array = [ // hexadecimal, network byte order
					   'version'      => $version,        // 4 bytes (60002)
					   'services'     => $services,       // 8 bytes
					   'timestamp'    => $timestamp,      // 8 bytes
					   'addr_recv'    => $recv,           // 26 bytes
					   'addr_from'    => $from,           // 26 bytes
					   'nonce'        => $nonce,          // 8 bytes
					   'user_agent'   => $user_agent,     // varint
					   'start_height' => $start_height    // 4 bytes
	];

	$version_payload = str_replace(' ', '', implode($version_array));
//	echo 'Version Payload: ';
//	print_r($version_array);

	return $version_payload;

}


// -----------------
// 2. SOCKET CONNECT
// -----------------

// Print socket error function
function error()
{
	$error = socket_strerror(socket_last_error());
	return $error . PHP_EOL;
}


// i. Create Version Message (needs to be sent to node you want to connect to)
//echo "Connect\n-------\n";
$payload      = makeVersionPayload($version, $node_ip, $node_port, $local_ip, $local_port);
$message      = makeMessage($payload);
$message_size = strlen($message) / 2; // the size of the message (in bytes) being sent


// ii. Connect to socket and send version message
$socketclose = true;
$socket = socket_create(AF_INET, SOCK_STREAM, 6); // IPv4, TCP uses this type, TCP protocol
socket_connect($socket, $node_ip, $node_port);
socket_send($socket, hex2bin($message), $message_size, 0); // don't forget to send message in binary


// iii. Keep receiving data (inv messages) from the node we just connected to
//echo "\nReceiving packets from $node_ip...\n\n";
while ($socketclose == true) {
	if (socket_recv($socket, $buffer, pow(2, 10), MSG_DONTWAIT)) {
//		echo $buffer."\n\n";
//		echo bin2hex($buffer) . "\n\n";
		$type = substr($buffer, 4, 12)."\n\n";
		$type_pos = strpos($type, "\0");
		if ($type_pos !== false) $type = substr($type, 0, $type_pos);
//		echo "|".$type."|";
		switch($type) {
			case 'version':
//				if ($this->version != 0) throw new Exception('Got version packet twice!');
				list(,$len) = unpack('V', substr($buffer, 16, 4));
				$payload = substr($buffer, 20, $len);
//				echo bin2hex($payload). "\n\n";
				echo json_encode(unpack('VnServices/Vversion/Vnoce/Valphs/V1timestamp', $payload)) . "\n\n";
				socket_close($socket);
				$socketclose = false;
				break;
			default:
//				throw new Exception('Unexpected packet type: '.$pkt['type'].' ['.bin2hex($pkt['type']).']');
		}
	}
}



/* Resources
    - https://en.bitcoin.it/wiki/Protocol_documentation
    - https://coinlogic.wordpress.com/2014/03/09/the-bitcoin-protocol-4-network-messages-1-version/
*/