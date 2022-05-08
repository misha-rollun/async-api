FROM node:14

RUN npm install -g @asyncapi/generator

RUN apt update && apt install -y  \
    git  \
    && rm -rf /var/lib/apt/lists/*

RUN git clone https://github.com/asyncapi/asyncapi-php-template /var/www/asyncapi-php

WORKDIR /var/www/asyncapi-php

RUN npm install
