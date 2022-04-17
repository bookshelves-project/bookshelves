#!/bin/bash

# git remote add framagit git@github.com:bookshelves-project/bookshelves-back.git
# git remote add framagit git@framagit.org:bookshelves-project/bookshelves-back.git

git push
git push github
git push framagit

git checkout main
git pull
git push github
git push framagit

git checkout develop

