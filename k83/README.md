# Kubernetes Environment
This documents is about kubernetes environment in a local mac.

## Installation

### Install Docker and Kubernetes

```sh
brew install docker docker-compose docker-machine

```
[Please enable kubectl on your GUI](https://docs.docker.com/docker-for-mac/#kubernetes)

```sh
kubectl config get-contexts
kubectl config use-context docker-for-desktop
```

### Install helm
```sh
brew install helm
helm init
helm install --name my-release stable/nginx-ingress
```

### Install skaffold
```
brew install skaffold
```

### openssl cert
You need to the cert for nginx ingress controller.

```sh
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /tmp/nginx-selfsigned.key -out /tmp/nginx-selfsigned.crt; openssl dhparam -out /tmp/sample.pem 2048
kubectl create secret tls tls-certificate --key /tmp/nginx-selfsigned.key --cert /tmp/nginx-selfsigned.crt
```

## Launch kubernetes

```sh
skaffold run
```

## Database Migration


```sh
API_POD=`kubectl get pods | grep product-service-api-deployment  | grep Running | awk '{ print $1 }'` && echo "ssh on $API_POD" && kubectl exec -it $API_POD -c php -- sh
php artisan migrate --seed
```

## Endpoint
You can access your app by the url below.
* You can not use 80 port to launch the end point in your Mac envrionment.

[http://dev-product-service.localhost/api/v1/products/all](http://dev-product-service.localhost/api/v1/products/all)

## Kubernetes Dashboard

```sh
cd ./dashboard
./run.sh

# You can paste the token on clipboard to sign in
./open_browser.sh
```
[Official document is here(Web UI (Dashboard)](https://kubernetes.io/docs/tasks/access-application-cluster/web-ui-dashboard/)