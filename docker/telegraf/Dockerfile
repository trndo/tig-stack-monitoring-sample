FROM telegraf

ARG DOCKER_GID=963
ADD docker/bin /usr/local/bin/
RUN /usr/local/bin/sync-user-id.sh telegraf "$USER_UID" "$USER_GID"
