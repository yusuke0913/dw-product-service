#!/bin/bash

kubectl create secret generic api-env --from-file=.env
