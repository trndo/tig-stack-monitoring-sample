#!/usr/bin/env bash

REPEATS=$1
CONCURRENCY=$2

siege -b -v -r"$REPEATS" -c"$CONCURRENCY" --content-type "application/x-www-form-urlencoded" -f urls.txt --log=siege-"$CONCURRENCY".txt
