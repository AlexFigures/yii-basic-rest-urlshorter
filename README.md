**Rest Api App for generate short links**

Based on Yii2 Basic Template


# Install:
`docker-compose up -d --build`

after builing run:

`docker-compose run --rm php-fpm_test  php yii migrate --interactive=0`

# Usage

make POST request with parameter 'full_url' :

`http://localhost/api/v1/link/create`

that action check for real url and back short link

make GET request:

`http://localhost/api/v1/link/{hash}`

that action get response with `full_url` and count of requests

make GET request:

`http://localhost/{hash}`

and it redirect to original url



