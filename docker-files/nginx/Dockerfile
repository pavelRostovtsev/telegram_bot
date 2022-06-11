FROM nginx:1.17.1-alpine

COPY ${PWD}/docker-files/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ${PWD}/docker-files/nginx/options-ssl-nginx.conf /etc/nginx/conf.d/options-ssl-nginx.conf

CMD ["nginx", "-g", "daemon off;"]
