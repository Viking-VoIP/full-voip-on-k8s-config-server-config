<?php

    include 'db_conn.php';

    if (!empty($_POST['cdr']))
    {
        $raw_data = file_get_contents('php://input') or die("I could not get the data");
        $xml = new SimpleXMLElement($_POST['cdr']);

        $writefile = fopen('/tmp/dump.txt',"w");

        $datetime_start=urldecode($xml->variables->start_stamp);
        $datetime_answer=urldecode($xml->variables->answer_stamp);
        $datetime_end=urldecode($xml->variables->end_stamp);
        $last_app=urldecode($xml->variables->last_app);
        $last_arg=urldecode($xml->variables->last_arg);
        $duration=urldecode($xml->variables->duration);
        $rtp_audio_in_mos=urldecode($xml->variables->rtp_audio_in_mos);
        $rtp_audio_in_packet_count=urldecode($xml->variables->rtp_audio_in_packet_count);
        $rtp_audio_in_skip_packet_count=urldecode($xml->variables->rtp_audio_in_skip_packet_count);
        $sip_from_user=urldecode($xml->variables->sip_from_user);
        $sip_from_display=urldecode($xml->variables->sip_from_display);
        $sip_to_user=urldecode($xml->variables->sip_to_user);
        $hangup_cause=urldecode($xml->variables->hangup_cause);
        $hangup_cause_q850=urldecode($xml->variables->hangup_cause_q850);
        $sip_call_id=urldecode($xml->variables->sip_call_id);
        $remote_media_ip=urldecode($xml->variables->remote_media_ip);
        $local_public_ip=urldecode($xml->variables->advertised_media_ip);
        $write_codec=urldecode($xml->variables->write_codec);
        $read_codec=urldecode($xml->variables->read_codec);
        $context=urldecode($xml->callflow->caller_profile->context);

        $query = "insert cdr values (NULL, '$datetime_start', '$sip_call_id', '$sip_from_user', '$sip_from_display', '$sip_to_user', '$datetime_answer', '$duration', '$rtp_audio_in_mos', '$rtp_audio_in_packet_count', '$rtp_audio_in_skip_packet_count', '$datetime_end', '$hangup_cause', '$hangup_cause_q850', '$remote_media_ip', '$read_codec', '$local_public_ip', '$write_codec', '$context', '$last_app', '$last_arg' );";

        fwrite($writefile,$query);
        $stm = $dbh->query($query);
        if ($stm) {
            http_response_code(200);
        } else {
            http_response_code(503);
        }

    } else {
        http_response_code(400);
        error_log( "No data in", 0 );
        print("No data in");
    }

?>