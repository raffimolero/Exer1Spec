FROM php:8.2-cli

RUN apt-get update

RUN apt-get install -y \
    npm

RUN npm install --global prettier @prettier/plugin-php

RUN docker-php-source extract \
	# do important things \
	docker-php-source delete

RUN apt-get install -y \
    imagemagick

WORKDIR /app
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod u+x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
