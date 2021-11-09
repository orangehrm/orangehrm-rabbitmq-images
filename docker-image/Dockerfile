FROM registry.access.redhat.com/ubi8/ubi:latest

COPY rabbitmq.repo /etc/yum.repos.d/rabbitmq.repo

RUN set -eux; \
	yum update -y; \
	yum -q makecache -y --disablerepo='*' --enablerepo='rabbitmq_erlang' --enablerepo='rabbitmq_server'; \
    yum install socat logrotate -y; \
    yum install --repo rabbitmq_erlang --repo rabbitmq_server erlang rabbitmq-server -y

ENV GOSU_VERSION=1.11
RUN gpg --keyserver hkps://keys.openpgp.org --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 \
    && curl -o /usr/local/bin/gosu -SL "https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-amd64" \
    && curl -o /usr/local/bin/gosu.asc -SL "https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-amd64.asc" \
    && gpg --verify /usr/local/bin/gosu.asc \
    && rm /usr/local/bin/gosu.asc \
    && rm -r /root/.gnupg/ \
    && chmod +x /usr/local/bin/gosu \
    # Verify that the binary works
    && gosu nobody true
    
ENV RABBITMQ_DATA_DIR=/var/lib/rabbitmq

# Added for backwards compatibility - users can simply COPY custom plugins to /plugins
RUN ln -sf /usr/lib/rabbitmq/lib/rabbitmq_server-3.9.8/plugins /plugins

COPY rabbitmq_delayed_message_exchange-3.9.0.ez /plugins

RUN set -eux; \
    rabbitmq-plugins enable --offline rabbitmq_management; \
    rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange

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

EXPOSE 5671 5672 15672 25672

CMD ["rabbitmq-server"]