<?php

echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
  <document type="freeswitch/xml">
    <section name="directory" description="Serving Directory Configuration for this user">
      <include>
        <user id="' . $_GET['user'] . '">
          <params>
            <param name="password" value="xyzzy"/>
            <param name="vm-enabled" value="true"/>
            <param name="vm-password" value="1234"/>
            <param name="vm-alternate-greet-id" value="8661234567"/>
          </params>
        </user>
      </include>
    </section>
  </document>';

?>