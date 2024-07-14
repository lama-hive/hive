## How to run (Windows WSL 2, Linux)
- docker-compose build --build-arg UID="$(id -u)"
- docker-compose up or docker-compose up -d
- in php container
    - composer config github-oauth.github.com $GITHUB_PUBLIC_KEY
    - composer install
- go to http://localhost
