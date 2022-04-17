#!/bin/bash

git push
git push github
git push framagit

git checkout main
git pull
git push github
git push framagit

git checkout develop

