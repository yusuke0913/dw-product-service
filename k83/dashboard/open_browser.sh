#!/bin/bash

./get_access_token.sh
open http://localhost:8001/api/v1/namespaces/kube-system/services/https:kubernetes-dashboard:/proxy
