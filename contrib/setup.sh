#!/bin/sh
PROJECT=`php -r "echo getcwd();"`
CONTRIB=$PROJECT/contrib

# Backup any existing pre-commit hooks
if [ -f $PROJECT/.git/hooks/pre-commit ]
then
  cp $PROJECT/.git/hooks/pre-commit $PROJECT/.git/hooks/pre-commit.bak
fi

# Link new hooks
touch $PROJECT/.git/hooks/pre-commit
rm $PROJECT/.git/hooks/pre-commit
ln -s $CONTRIB/pre-commit $PROJECT/.git/hooks/pre-commit
chmod +x $PROJECT/.git/hooks/pre-commit
