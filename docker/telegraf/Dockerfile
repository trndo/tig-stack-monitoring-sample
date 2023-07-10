FROM telegraf

ARG DOCKER_GID=963
ADD docker/bin/sync-user-id.sh /usr/local/bin/sync-user-id.sh
RUN /usr/local/bin/sync-user-id.sh telegraf "$USER_UID" "$USER_GID"
