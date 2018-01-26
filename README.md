# gluons
gluons is a database searvice to hold the all relations among everything in the universe.

# Service URL
http://gluons.link (English)

http://ja.gluons.link (日本語)

# Requirement

* Linux
* Apache
* MySQL
* PHP
* composer

# Prepare the application source

    $ cd /{source_dir_path}
    $ git checkout master
    $ rm -fr vendor/j7mbo
    $ composer install

※vendor/j7mbo/twitter-api-php が上手くgit管理できないため

# Prepare Databae

    Build MySQL database named 'belongsto'
    Build MySQL user named 'belongsto' (password is in config/app.php)

# Prepare Tables

    $ cd /{source_dir_path}
    $ bin/cake migrations migrate

# Prepare Table Datas

    $ mysql -ubelongsto -p{password} belongsto < /{source_dir_path}


# Run local server

    $ cd /{source_dir_path}
    $ bin/cake server
