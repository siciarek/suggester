Application setup
-----------------

System requirements
===================

    * PHP >= 5.4
    * PHP Extensions
        - php_phalcon >= 1.3.2
        - php_openssl
        - php_curl
        - php_sqlite3
    * Server side applications
        - composer
        - ant
        - python (sphinx)
        - latex (optional when pdf docs are required)

Each of the following commands should be run in the directory where project was deployed eg. ``/var/www/suggester``.

Setting up configuration
========================

.. code-block:: bash

    $ cp properties.cnf.dist properties.cnf
    $ cp app/config/config.ini.dist app/config/config.ini
    $ mkdir app/cache
    $ mkdir .phalcon

Content of ``properties.cnf`` and ``app/config/config.ini`` should be customized.

Setting up database
===================

.. code-block:: bash

    $ php app/console db

or

.. code-block:: bash

    $ and db

Running tests
=============

.. code-block:: bash

    $ bin/behat


