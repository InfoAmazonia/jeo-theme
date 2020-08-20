#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR/../

sudo docker-compose exec wordpress wp "$@" 

cd $CDIR
