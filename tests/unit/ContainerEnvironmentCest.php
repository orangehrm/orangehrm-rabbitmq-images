<?php

class ContainerEnvironmentCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function vefiryOSVersionTest (UnitTester $I)
    {
        $I->wantTo("Veify the container os version - RHEL 8.4");
        $I->runShellCommand("docker exec rabbitmq_container cat /etc/os-release | grep PRETTY_NAME | cut -d'=' -f 2"); 
        $I->seeInShellOutput("Red Hat Enterprise Linux 8.4 (Ootpa)");
    }

    public function vefiryInstalledRabbitMQVersionTest (UnitTester $I)
    {
        $I->wantTo("Veify the RabbitMQ version - 3.9.8");
        $I->runShellCommand("docker exec rabbitmq_container rabbitmqctl --version"); 
        $I->seeInShellOutput("3.9.8");
    }
}
