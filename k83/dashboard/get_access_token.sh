#!/bin/bash

TOKEN=`kubectl -n kube-system describe secret $(kubectl -n kube-system get secret | grep eks-admin | awk '{print $1}') | grep token`

echo $TOKEN | awk -F 'token: ' ' { print $2 }' | pbcopy

