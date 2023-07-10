FROM node:18

WORKDIR /var/www/book_ms_app/client

COPY ./client/package*.json .

RUN npm install

COPY ./client .

EXPOSE 3000

CMD [ "npm", "run", "dev" ]
