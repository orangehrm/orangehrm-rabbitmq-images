<?php

class RabbitMQConfigurationCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function verifyManagementPluginIsEnabledTest(UnitTester $I)
    {
        $I->wantTo("Veify the Management Plugin is installed");
        $I->runShellCommand("docker exec rabbitmq_container rabbitmq-plugins list -e"); 
        $I->seeInShellOutput("rabbitmq_management");
    }

    public function verifyDelayedMessageExchangePluginIsEnabledTest(UnitTester $I)
    {
        $I->wantTo("Veify the Delayed Message Exchange Plugin is installed");
        $I->runShellCommand("docker exec rabbitmq_container rabbitmq-plugins list -e"); 
        $I->seeInShellOutput("rabbitmq_delayed_message_exchange");
    }
}
