#!/bin/bash
set -e

sleep 10s
rabbitmq-plugins enable --offline rabbitmq_management
rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange

exec "$@"