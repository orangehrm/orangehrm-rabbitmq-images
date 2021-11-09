#!/bin/bash
set -e

rabbitmq-plugins enable --offline rabbitmq_management
rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange

exec "$@"