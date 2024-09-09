#!/bin/bash

echo "Checking if the artisan service is running..."
docker-compose up -d artisan

echo "Running Laravel tests..."
docker-compose exec artisan php artisan test

if [ $? -eq 0 ]; then
  echo "All tests passed successfully!"
else
  echo "Some tests failed. Please check the output for details."
fi

read -n 1 -s -r -p "Press any key to continue..."
echo
