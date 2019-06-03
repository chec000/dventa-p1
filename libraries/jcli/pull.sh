#!/bin/bash -x
echo "update library Jcli ..."
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/zitdev
ssh-add -l
cd $HOME'/Descargas/lib_jcli'
composer clearcache
composer update
eval 'ssh-agent -k'
