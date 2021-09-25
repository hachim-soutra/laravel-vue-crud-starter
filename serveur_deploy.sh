git fetch origin main
git reset --hard origin/main
php -d memory_limit=-1 composer.phar update
php artisan migrate
echo "Application deployed!"
