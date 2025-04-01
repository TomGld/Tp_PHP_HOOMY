#!/usr/bin/sh
 mariadb-dump hoomy -uroot -psuperAdmin > /root/init.sql
 echo "Sauvegarde terminée"