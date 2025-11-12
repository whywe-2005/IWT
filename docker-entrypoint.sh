#!/bin/sh

# CRITICAL FIX: Sleep for 10 seconds to allow the MySQL service 
# to fully initialize and create the 'event_db' database and tables.
echo "Waiting 10 seconds for the database to become available..."
sleep 10

# Execute the default PHP-FPM command after the wait is complete
exec docker-php-entrypoint "$@"