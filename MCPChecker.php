<?php

	function sendmail($to,$subject,$body,$sender = 'noreply') {
        try {
            require_once('/usr/share/php/Mail.php');

            $from = '';
            $host = '';
            $port = 587;
            $username = '';
            $password = '';

            $headers = array ('debug' => true,
                'From' => $sender.' <'.$from.'>',
                'To' => $to,
                'Content-Type' => "text/html",
                'charset' => "ISO-8859-1",
				'MIME-Version' => "1.0",
				'Reply-To' => $from,
				'CC' => $from,
				'Subject' => $subject);

			$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
			$mail = $smtp->send($to, $headers, $body);

			if (PEAR::isError($mail)) {
				return "There was an error sending your message, please try again later.";
			} else {
				return "Message successfully sent";
			}

        } catch (Exception $e) {
            return $e->getMessage();
        }
	}

	$MCP_VERSION = '1.11.1';
	$EMAIL_TO = '<Your email address>';
	
	echo 'MCP Scanner V.0.1'.PHP_EOL;
	echo 'Scanning for mappings...'.PHP_EOL;

    $uri = 'http://files.minecraftforge.net/maven/de/oceanlabs/mcp/mcp/'.$MCP_VERSION.'/mcp-'.$MCP_VERSION.'-srg.zip';
	$output = 'Found no mappings for '.$MCP_VERSION.' :(';
	
    $handle = curl_init($uri);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($httpCode == 200) {
        $output = sendmail($EMAIL_TO,'MCP Mappings for MC '.$MCP_VERSION,'MCP Mappings for MC '.$MCP_VERSION.' is now available, download at '.$uri,'MCPBotScanner');
    } else {
        $content = file_get_contents('http://export.mcpbot.bspk.rs/');
        if (preg_match('#:(.*?)'.$MCP_VERSION.'(.*?).zip#',$content,$matches)) {
			$output = sendmail($EMAIL_TO,'MCP Mappings for MC '.$MCP_VERSION,'MCP Mappings for MC '.$MCP_VERSION.' is now available, download at http'.$matches[0],'MCPBotScanner');
        } else {
			$content = file_get_contents('https://bitbucket.org/ProfMobius/mcpbot/commits/all');
			if (preg_match('#(.*?)'.$MCP_VERSION.'(.*?)"',$content,$matches)) {
				$output = sendmail($EMAIL_TO,'MCP Mappings for MC '.$MCP_VERSION,'MCP Mappings for MC '.$MCP_VERSION.' is now available, download at https://bitbucket.org/ProfMobius/mcpbot/commits/all','MCPBotScanner');
			}
		}
    }

	echo $output.PHP_EOL;

?>