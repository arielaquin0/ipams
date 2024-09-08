FROM node:20

WORKDIR /var/www/frontend

COPY frontend/package*.json ./

RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "run", "dev"]
