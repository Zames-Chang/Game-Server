#!/bin/sh

echo "$DOCKER_PASSWORD" | docker login -u="$DOCKER_USERNAME" --password-stdin
docker run --rm -v ${TRAVIS_BUILD_DIR}:/app -w /app composer:1.6.5 composer install --ignore-platform-reqs --no-dev
docker build --pull --no-cache -t "hashman/game-server:$TRAVIS_BRANCH" .
docker tag "hashman/game-server:$TRAVIS_BRANCH" "hashman/game-server:$TRAVIS_BRANCH"
docker push "hashman/game-server:$TRAVIS_BRANCH"
