<?php

class ContainerEnvironmentCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function vefiryOSVersionTest (UnitTester $I)
    {
        $I->wantTo("Veify the container os version - Ubuntu 20.04");
        $I->runShellCommand("docker exec rabbitmq_container cat /etc/os-release | grep PRETTY_NAME | cut -d'=' -f 2"); 
        $I->seeInShellOutput("Ubuntu 20.04.3 LTS");
    }

    public function vefiryInstalledRabbitMQVersionTest (UnitTester $I)
    {
        $I->wantTo("Veify the RabbitMQ version - 3.8.2");
        $I->runShellCommand("docker exec rabbitmq_container rabbitmqctl --version"); 
        $I->seeInShellOutput("3.8.2");
    }
}
