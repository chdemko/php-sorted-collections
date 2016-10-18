#!/bin/bash

if [ "$TRAVIS_REPO_SLUG" == "chdemko/php-sorted-collections" ] && [ "$TRAVIS_PHP_VERSION" == "5.5" ] && [ "$TRAVIS_PULL_REQUEST" == "false" ] && [ "$TRAVIS_BRANCH" == "master" ]; then

  echo -e "Publishing code coverage to coveralls.io ...\n"

  php vendor/bin/coveralls -v

  echo -e "Published code coverage to coveralls.io\n"
  
  echo -e "Publishing doc...\n"

  cp -R build/api $HOME/api-latest
  cp -R build/coverage $HOME/coverage-latest

  cd $HOME
  git config --global user.email "travis@travis-ci.org"
  git config --global user.name "travis-ci"
  git clone --quiet --branch=gh-pages https://${GH_TOKEN}@github.com/chdemko/php-sorted-collections gh-pages > /dev/null

  cd gh-pages
  git rm -rf ./api
  git rm -rf ./coverage
  touch .nojekyll
  cp -Rf $HOME/api-latest ./api
  cp -Rf $HOME/coverage-latest ./coverage

  git add -f .
  git commit -m "Latest doc on successful travis build $TRAVIS_BUILD_NUMBER auto-pushed to gh-pages"
  git push -fq origin gh-pages > /dev/null

  echo -e "Published doc to gh-pages.\n"

fi
