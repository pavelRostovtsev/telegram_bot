FROM nginx:1.17.1-alpine

COPY ${PWD}/docker-files/nginx/default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]
