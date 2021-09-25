git fetch origin main
git reset --hard origin/main

read -p "Do you want to upadte composer ? (y,n)" yn
case $yn in
    [Yy])
        echo start  upadte composer..
        php -d memory_limit=-1 composer.phar update
    ;;
    *)
        echo No migration..
    ;;
esac


read -p "Do you wish to migarte? (y,n)" yn
case $yn in
    [Yy])
        echo start migration..

        php artisan migrate
    ;;
    *)
        echo No migration...
    ;;
esac

echo "Application deployed!"
