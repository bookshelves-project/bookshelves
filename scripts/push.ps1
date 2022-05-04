# git remote add gitlab git@gitlab.com:bookshelves-project/bookshelves-front.git
# git remote add github git@github.com:bookshelves-project/bookshelves-front.git
# git remote add framagit git@framagit.org:bookshelves-project/bookshelves-front.git

git push
git push github
git push framagit

git checkout main
git pull
git push github
git push framagit

git checkout develop

