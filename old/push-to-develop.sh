git checkout develop
git pull develop develop
git add .
echo -n 'Commit Message: '
read commitMessage
git commit -m "$commitMessage"
git push develop develop HEAD:master
git checkout origin
#git merge develop
git checkout develop
git push origin develop 
#HEAD:master
