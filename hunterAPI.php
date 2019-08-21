<?php
if(isset($_GET['domain']) && $_GET['domain'] != '')
{    
    $thisEmailDomain = $_GET['domain'];
    // We can have multiple API keys
    $keysArr = array("USE_HUNRTER API KEY(s)");
    $selectedApiKey = '';                        
    for($k=0;$k<1;$k++)
    {     
        $ch = curl_init();
        $url = "https://api.hunter.io/v2/account?api_key=".$keysArr[$k];
        curl_setopt($ch,CURLOPT_URL, $url);
        $headr[] = "";
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($result);
        if(isset($resp->data->calls->used))
            $apiUsed = $resp->data->calls->used;
        else
            $apiUsed = -1;

        if($apiUsed > 0 && $apiUsed < 100)
            $selectedApiKey = $keysArr[$k];
    }

    
    if($selectedApiKey != '')
    {    
            $ch = curl_init();
            $url = "https://api.hunter.io/v2/domain-search?domain=".$thisEmailDomain."&api_key=$selectedApiKey";
            curl_setopt($ch,CURLOPT_URL, $url);
            $headr[] = "";
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            $resp = json_decode($result);
            
            echo "<br>Hunter Pattern:".$resp->data->pattern;
    }
    else 
    {
        echo "<br>Key have exceeded API limit.";
    }
}                        
?>                        