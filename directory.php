<?php

echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
  <document type="freeswitch/xml">
    <section name="directory" description="Serving Directory Configuration for this user">
      <domain name="' . $_POST['domain'] . '">
        <user id="' . $_POST['user'] . '">
	      <params>
            <param name="vm-storage-dir" value="/efs"/>
            <param name="vm-storage-dir-shared" value="true"/>
            <param name="password" value="xyzzy"/>
            <param name="vm-enabled" value="true"/>
            <param name="vm-password" value="1234"/>
            <param name="vm-alternate-greet-id" value="8661234567"/>
          </params>
        </user>
      </domain>
    </section>
  </document>';

?>