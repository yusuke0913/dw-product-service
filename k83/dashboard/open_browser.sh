#!/bin/bash

./get_access_key.sh
echo Pbcopy token on clipboard
open http://localhost:8001/api/v1/namespaces/kube-system/services/https:kubernetes-dashboard:/proxy
