# Tag the image to point to the local registry
```
docker tag app_v1_webservice:latest localhost:5000/app_v1_webservice:latest
```
# Push the image to the local registry
docker push localhost:5000/app_v1_webservice:latest
