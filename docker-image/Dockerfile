FROM ubuntu:20.04

RUN set -eux; \
	apt update; \
	apt install -y --no-install-recommends gosu; \
    apt install -y rabbitmq-server; \
    apt install -y openssl

ENV RABBITMQ_DATA_DIR=/var/lib/rabbitmq

# Added for backwards compatibility - users can simply COPY custom plugins to /plugins
RUN ln -sf /usr/lib/rabbitmq/lib/rabbitmq_server-3.8.2/plugins /plugins

COPY rabbitmq_delayed_message_exchange-3.8.0.ez /plugins

RUN set -eux; \
    gosu rabbitmq rabbitmq-plugins enable --offline rabbitmq_management; \
    gosu rabbitmq rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange

RUN set -eux; \
    gosu nobody true; \
    gosu rabbitmq rabbitmqctl help; \
	gosu rabbitmq rabbitmqctl list_ciphers; \
	gosu rabbitmq rabbitmq-plugins list

# set home so that any `--user` knows where to put the erlang cookie
ENV HOME $RABBITMQ_DATA_DIR

# Hint that the data (a.k.a. home dir) dir should be separate volume
VOLUME $RABBITMQ_DATA_DIR

# warning: the VM is running with native name encoding of latin1 which may cause Elixir to malfunction as it expects utf8. Please ensure your locale is set to UTF-8 (which can be verified by running "locale" in your shell)
# Setting all environment variables that control language preferences, behaviour differs - https://www.gnu.org/software/gettext/manual/html_node/The-LANGUAGE-variable.html#The-LANGUAGE-variable
# https://docs.docker.com/samples/library/ubuntu/#locales
ENV LANG=C.UTF-8 LANGUAGE=C.UTF-8 LC_ALL=C.UTF-8

COPY entrypoint.sh /usr/local/bin/

RUN ln -s /usr/local/bin/entrypoint.sh /
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

EXPOSE 4369 5671 5672 15691 15692 25672
CMD ["rabbitmq-server"]