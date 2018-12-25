#!/bin/bash

kubectl delete -f api-migration-job.yaml
kubectl apply -f  api-migration-job.yaml
