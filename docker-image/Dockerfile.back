FROM rabbitmq:3.8.4-management

# Enable RabbitMQ Delayed Message Exchange Plugin 
COPY rabbitmq_delayed_message_exchange-3.8.0.ez /plugins
RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange