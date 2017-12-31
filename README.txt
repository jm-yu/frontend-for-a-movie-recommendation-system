
This a frontend webpage for a movie recommendation project. It includes a login part, a user-data collection part.

html + css + JQuery + php + mysql
12.22 
  update:the next step is to replant this project on Google Cloud Platform, rent a dns and make it public.

12.23 
  Procedures to connect an VM instance from an MacBook-pro.
1.create new SSH keys on your local machine.
  ssh-keygen -t rsa -f ~/.ssh/[KEY_FILENAME] -C [USERNAME]
where:
  [USERNAME] is the user that this key applies to. Since I was using Google Cloud Platform, it is supposed to something like yourUserName@external_ip
  chmod 400 ~/.ssh/[KEY_FILENAME]
  Restrict access to your private key so that only you can read it and nobody can write to it
2.add public key to instance
  Paste contents of file [KEY_FILENAME].pub(should be in ~.ssh/) to VM instance.
3.connect to instance
  Use commend:
  ssh -i [PATH_TO_PRIVATE_KEY] [yourUserName@external_ip]


12.31
  http://35.196.58.1/index.php


reference:
  W3school.com
  https://github.com/therecluse26/PHP-Login



