#!/bin/bash
 
echo "
Symfony 1.4 project generator - Rick Smith (foxsoup)
====================================================
This script will create a new directory, clone the Github-hosted Symfony 1.4
repository into it as a submodule (equivalent of an SVN external) and
initialise a new project with a standard frontend app.
"
 
if [ -z "$1" ]; then
  echo "Usage: $0 project_name"
  exit 1
fi
 
read -p "The following directory will be created:

./$1

Press enter to continue or Ctrl-C to abort.
"
 
mkdir $1
cd $1
git init
 
git clone git://github.com/symfony/symfony1.git ./lib/vendor/symfony
git submodule add git://github.com/symfony/symfony1.git ./lib/vendor/symfony
git submodule init && git submodule update
 
git commit -m 'First commit.'
 
./lib/vendor/symfony/data/bin/symfony generate:project $1
 
echo "config/databases.yml
cache/*
log/*
data/sql/*
web/uploads/*" > .gitignore
 
./symfony project:permissions
git add .
git commit -m 'Initialised project.'
 
./symfony generate:app frontend
git add .
git commit -m 'Initialised frontend app.'
 
echo "
All done!

Next steps:
  * Set up your project database and run 'symfony configure:database'.
  * Add any extra plugins (sfDoctrineGuardPlugin, etc) as submodules and run
    'symfony plugin:publish-assets'.
  * Run 'git remote add origin ...' to add a remote repository such as Github.
  * Commit and push to remote if applicable.
"
