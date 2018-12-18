#!/bin/sh

if [ -z ${USER_NAME} ]; then
		echo "Please export your docker hub username"
		echo "export USER_NAME=your docker hub username"
		exit 1
fi

for TARGET in ${TARGET} php
do
		echo Tagging $TARGET ...
		docker tag product-service-${TARGET}:latest ${USER_NAME}/product-service-${TARGET}:latest

		echo Pushing $TARGET ...
		docker push ${USER_NAME}/product-service-${TARGET}:latest
done



