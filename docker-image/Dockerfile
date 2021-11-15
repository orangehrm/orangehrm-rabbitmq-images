FROM centos:7

COPY config/rabbitmq.repo /etc/yum.repos.d/rabbitmq.repo

RUN set -eux; \
	yum update -y; \
	yum install socat logrotate -y; \
    yum install erlang rabbitmq-server-3.9.8 -y
    
ENV RABBITMQ_DATA_DIR=/var/lib/rabbitmq

# Added for backwards compatibility - users can simply COPY custom plugins to /plugins
RUN ln -sf /usr/lib/rabbitmq/lib/rabbitmq_server-3.9.8/plugins /plugins

COPY config/rabbitmq_delayed_message_exchange-3.9.0.ez /plugins

# set home so that any `--user` knows where to put the erlang cookie
ENV HOME $RABBITMQ_DATA_DIR

# Hint that the data (a.k.a. home dir) dir should be separate volume
VOLUME $RABBITMQ_DATA_DIR

COPY entrypoint.sh /usr/local/bin/

RUN ln -s /usr/local/bin/entrypoint.sh /
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

EXPOSE 5671 5672 15672 25672

CMD ["rabbitmq-server"]