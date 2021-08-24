<?php

    if(!empty($_POST['CampaignId']))
    {
        require 'aws-autoloader.php';

        use Aws\S3\S3Client;

        $client = S3Client::factory( array(
            'region' => 'eu-west-1',
            'version' => 'latest',
            "scheme" => "http"
        ));

        $uniqueid = uniqid();

        $caller_id_number   = $_POST['FromNumber'];
        $destination_number = $_POST['ToNumber'];
        $start_stamp        = $_POST['start_stamp'];
        $billsec            = $_POST['billsec'];
        $phonedesc          = $_POST['phoneDesc'];
        $hangup_cause       = $_POST['hangup_cause'];
        $campaign_id        = $_POST['CampaignId'];
        $result             = $_POST['result'];

        if (!empty($_POST['dtmf_get'])) $dtmf_get           = $_POST['dtmf_get'];

        $cdrline = "";
        $cdrline = $cdrline . $caller_id_number . ",";
        $cdrline = $cdrline . $destination_number . ",";
        $cdrline = $cdrline . $start_stamp . ",";
        $cdrline = $cdrline . $billsec . ",";
        $cdrline = $cdrline . $phonedesc . ",";
        $cdrline = $cdrline . $hangup_cause . ",";
        $cdrline = $cdrline . $campaign_id . ",";
        $cdrline = $cdrline . $result;

        if (!empty($_POST['dtmf_get'])) $cdrline = $cdrline . "," . $dtmf_get;

        error_log( "Caller       : " . $caller_id_number );
        error_log( "Called       : " . $destination_number );
        error_log( "Start        : " . $start_stamp );
        error_log( "Billsec      : " . $billsec );
        error_log( "PhoneDesc    : " . $phonedesc );
        error_log( "HangupCause  : " . $hangup_cause );
        error_log( "CamapignId   : " . $campaign_id );
        error_log( "Result       : " . $result );

        if (!empty($_POST['dtmf_get'])) error_log( "DtmfGet      : " . $dtmf_get );

        error_log( "CDR Line: " . $cdrline . " -> " . $uniqueid );

        try {
            // Send a PutObject request and get the result object.
            $result = $client->putObject(array(
                    'Bucket' => 'massphoning-cdr-dev',
                    'Key' => $campaign_id . '/' . $uniqueid . ".log",
                    'Body' => $cdrline
            ));
        } catch (Exception $e) {
            error_log( "Coudn't post the CDR file to S3, ERROR: " . $e );
        }
    }
?>