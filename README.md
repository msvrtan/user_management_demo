user management demo
====================


1) run vagrant

vagrant up

2) log into vagrant

vagrant ssh

3) clear caches

sudo chmod 777 -R /run/shm/appname

4)Functional tests

./bin/behat

5) Unit tests

./bin/phpspec run

Task was:
===

Epic: User management system

Stories:

- As an admin I can add users - A user has a name

- As an admin I can delete users

- As an admin I can assign users to a group they aren’t already part of

- As an admin I can remove users from a group

- As an admin I can create groups

- As an admin I can delete groups when they no longer have members


