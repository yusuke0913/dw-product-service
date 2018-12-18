# Kubernetes Environment


## Installation

### Docker
```sh
brew install docker docker-compose docker-machine

```
[Please enable kubectl on your GUI](https://docs.docker.com/docker-for-mac/#kubernetes)

```sh
kubectl config get-contexts
kubectl config use-context docker-for-desktop
```

### helm
```sh
brew install heml
helm init
helm install --name my-release stable/nginx-ingress
```

### skaffold
```
brew install skaffold
```

### openssl cert
```sh
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /tmp/nginx-selfsigned.key -out /tmp/nginx-selfsigned.crt; openssl dhparam -out /tmp/sample.pem 2048
kubectl create secret tls tls-certificate --key /tmp/nginx-selfsigned.key --cert /tmp/nginx-selfsigned.crt
```


### Launch kubernetes

```sh
skaffold run
```

### Database Migration

```sh
API_POD=`kubectl get pods | grep product-service-api-deployment | awk '{ print $1 }'`
kubectl exec -it $API_POD -c php -- sh
php artisan migrate --seed
```

### Browser
You can access your app by the url below.
[http://dev-product-service.localhost/api/v1/products](http://dev-product-service.localhost/api/v1/products)

## Dashboard

```sh
cd ./dashboard
./run.sh

# copied token to access on clipboard
./open_browser.sh
```
[Official document is here(Web UI (Dashboard)](https://kubernetes.io/docs/tasks/access-application-cluster/web-ui-dashboard/)```