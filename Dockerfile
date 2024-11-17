FROM php:8.2-cli

RUN apt-get update

RUN apt-get install -y \
    npm

RUN npm install --global prettier @prettier/plugin-php

RUN apt-get install -y \
    imagemagick

WORKDIR /app
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod u+x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
