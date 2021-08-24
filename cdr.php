<?php
    require 'aws-autoloader.php';

    use Aws\S3\S3Client;
    // phpinfo();
    // $writefile = fopen('/tmp/dump.txt',"w");
    // fwrite($writefile, $raw_cdr);
    // fclose($writefile);

    if (!empty($_POST['cdr']))
    {
        $raw_cdr = $_POST['cdr'];
        $myXMLData = $raw_cdr;

        $xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");

        if( $direction=$xml->variables->direction == "outbound" )
        {
            //$caller_id_name=$xml->callflow->caller_profile->caller_id_name;
            $caller_id_number=$xml->callflow->caller_profile->caller_id_number;
            //$caller_id_number=trim($caller_id_number);
            $destination_number=$xml->callflow->caller_profile->callee_id_number;
            //$context=$xml->callflow->caller_profile->context;
            $start_stamp=$xml->variables->start_epoch;
            $phonedesc=$xml->variables->app_phone_desc;
            $hangup_cause=$xml->variables->hangup_cause;
            $campaign_type=$xml->variables->app_campaing_type;
            $dtmf_get=$xml->variables->dtmf_get;
            //$epoch = trim($start_stamp); 
            //date_default_timezone_set('Asia/Kolkata');
            //$newdate= (string)date('Ymd_H_i_s', $epoch);
            //$start=date('r', $start_stamp."<br>");
            //$answer_stamp=$xml->variables->answer_epoch;
            //$answer=date('r', $answer_stamp."<br>");
            //$end_stamp=$xml->variables->end_epoch;
            //$end=date('r', $end_stamp."<br>");
            //$duration=$xml->variables->duration;
            $billsec=$xml->variables->billsec;
            $hangup_cause=$xml->variables->hangup_cause;
            //$uuid=$xml->callflow->caller_profile->uuid;

            error_log( "Caller       : " . $caller_id_number );
            error_log( "Called       : " . $destination_number );
            error_log( "Start        : " . $start_stamp );
            error_log( "Billsec      : " . $billsec );
            error_log( "PhoneDesc    : " . $phonedesc );
            error_log( "HangupCause  : " . $hangup_cause );
            error_log( "DtmfGet      : " . $dtmf_get );
            error_log( "CamapignType : " . $campaign_type );
        }
    } else {
        error_log( "No data in", 0 );
        print("No data in");
    }

?>