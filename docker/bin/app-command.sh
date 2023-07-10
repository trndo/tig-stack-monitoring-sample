#!/bin/bash

while true; do
    php /usr/src/app/bin/console app:currency-rate
    sleep 3600
done