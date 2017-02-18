FROM ubuntu:16.04

MAINTAINER Amit Kumar Jaiswal "amitkumarj441@gmail.com"

# Install nginx
ENV HOME /root
RUN apt-get update && \
	apt-get install -y nginx && \
	echo "daemon off;" >> /etc/nginx/nginx.conf

RUN locale-gen en_US.UTF-8 && \
    echo 'LANG="en_US.UTF-8"' > /etc/default/locale && \
	dpkg-reconfigure locales

# Install Postgresql
VOLUME ["/data/pgsql"]
RUN apt-get update && \
	apt-get -y install postgresql-9.3 && \
	apt-get -y install postgresql-contrib-9.3

# We start it here to allow the default directory to seed with the db setup
RUN /etc/init.d/postgresql start && \
	sed -i -e"s/data_directory =.*$/data_directory = '\/data\/pgsql'/" /etc/postgresql/9.3/main/postgresql.conf && \
	echo "listen_addresses = '*'" >> /etc/postgresql/9.3/main/postgresql.conf && \
	echo 'local all all peer' >> /etc/postgresql/9.3/main/pg_hba.conf && \
	echo 'adminmap   postgres         postgres' >> /etc/postgresql/9.3/main/pg_ident.conf && \
	echo "host all all 0.0.0.0/0 md5" >> /etc/postgresql/9.3/main/pg_hba.conf && \
	chown -R postgres:postgres /data/


# Install PHP7 and modules along with composer binary
RUN apt-get install -y curl git && \
	apt-get -y install php7-fpm php7-pgsql php-apc php7-mcrypt php7-curl php7-gd php7-json php7-cli libssh2-php && \
	sed -i -e "s/short_open_tag = Off/short_open_tag = On/g" /etc/php7/fpm/php.ini && \
	sed -i -e "s/post_max_size = 8M/post_max_size = 20M/g" /etc/php7/fpm/php.ini && \
	sed -i -e "s/upload_max_filesize = 2M/upload_max_filesize = 20M/g" /etc/php7/fpm/php.ini && \
	curl -sS https://getcomposer.org/installer | php && \
	mv composer.phar /usr/local/bin/composer

# Configure nginx for PHP websites
RUN echo "cgi.fix_pathinfo = 0;" >> /etc/php7/fpm/php.ini && \
	echo "max_input_vars = 10000;" >> /etc/php7/fpm/php.ini && \
	echo "date.timezone = Europe/London;" >> etc/php7/fpm/php.ini

# Setup supervisor
RUN apt-get install -y supervisor cron
ADD supervisor/cron.conf /etc/supervisor/conf.d/
ADD supervisor/nginx.conf /etc/supervisor/conf.d/
ADD supervisor/php.conf /etc/supervisor/conf.d/
ADD supervisor/postgresql.conf /etc/supervisor/conf.d/
ADD supervisor/user.conf /etc/supervisor/conf.d/
ADD supervisor/postgresql-start.sh /etc/supervisor/conf.d/postgresql-start.sh
RUN chmod +x /etc/supervisor/conf.d/postgresql-start.sh

# Disallow key checking
RUN echo "StrictHostKeyChecking no" >> /etc/ssh/ssh_config

# Adds the default server to nginx config
ADD config/nginx.conf /etc/nginx/sites-available/default

# Internal Port Expose
EXPOSE 80 443

ADD ./ /var/www/
CMD ["/usr/bin/supervisord", "-n"]
