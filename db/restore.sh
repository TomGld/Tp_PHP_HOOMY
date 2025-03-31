#!/usr/bin/sh
 
 mariadb hoomy -uroot -psuperAdmin < /root/init.sql
 echo "Restauration terminée"