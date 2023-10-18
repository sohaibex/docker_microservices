#!/bin/bash

# Debug: Print the environment variable
echo "Debug: WEBSERVICE_PORT is set to $WEBSERVICE_PORT"

# Modify the configuration file directly in its original location
sed -i "s/Define WEBSERVICE_PORT .*/Define WEBSERVICE_PORT $WEBSERVICE_PORT/" /etc/apache2/sites-enabled/webservice.conf

# Debug: Print the modified configuration file
echo "===== Modified Configuration ====="
cat /etc/apache2/sites-enabled/webservice.conf
echo "================================="

# Print a confirmation message (you already have this line)
echo "********WEBSERVICE_PORT is set to $WEBSERVICE_PORT***********"

# Run the original command
exec "$@"