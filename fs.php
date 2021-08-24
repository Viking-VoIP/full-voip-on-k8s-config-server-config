<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<document type="freeswitch/xml">
    <section name="dialplan" description="RE Dial Plan For FreeSwitch">

        <context name="public">

            <extension name="unloop">
                <condition field="${unroll_loops}" expression="^true$"/>
                <condition field="${sip_looped_call}" expression="^true$">
                    <action application="deflect" data="${destination_number}"/>
                </condition>
            </extension>

            <extension name="info_data" continue="true">
                <condition field="destination_number" data=".*">
                    <action application="info"/>
                </condition>
            </extension>

            <extension name="test">
                <condition field="destination_number" expression="^9999$">
                    <action application="answer"/>
                    <action application="echo" data=""/>
                </condition>
            </extension>

            <extension name="echo_test">
                <condition field="destination_number" expression="^5551212$">
                    <action application="answer"/>
                    <action application="echo"/>
                    <action application="hangup"/>
                </condition>
            </extension>

            <extension name="gateway_inbound">
                <condition field="${target_context}" expression="^[a-z]"/>
                <condition field="${domain}" expression="^[a-z]">
                    <action application="set" data="domain_name=${domain}"/>
                    <action application="transfer" data="${destination_number} XML ${target_context}"/>
                </condition>
            </extension>

            <extension name="user-to-user">
                <condition field="${destination_number}" expression="^7[0-9]{8}$">
                    <action application="set" data="application=USER-TO-USER"/>
                    <action application="bridge" data="sofia/external/721113210@sip-proxy.service.consul:5066"/>
                    <action application="hangup"/>
                </condition>
            </extension>

            <extension name="hangup">
                <condition field="destination_number" expression="^hangup$">
                    <action application="hangup" date="NORMAL_CLEARING"/>
                </condition>
            </extension>

        </context>
    </section>
</document>
