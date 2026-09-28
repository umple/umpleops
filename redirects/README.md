# umple.org redirects

`mapping.php` forwards the umple.org subdomains (try, cruise, manual) and the short links such as umple.org/dl and umple.org/issues.

On the server it lives at `/var/www/html/mapping.php`. The `index.php` in the web root and in each short-link folder is a symlink to it, so a new short link needs a `case` in `mapping.php` and a folder with that symlink:

    mkdir /var/www/html/NAME && ln -s ../mapping.php /var/www/html/NAME/index.php

Run `./test.sh` before copying a change to the server. It needs PHP and curl.
