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

Setting up behat
================

Open ``behat.yml.dist`` and copy commented lines


.. code-block:: yaml

    ## behat.yml
    #
    #imports:
    #    resource: behat.yml.dist
    #
    #default:
    #
    #    formatters:
    #         pretty: ~
    #         progress: false
    #
    #    extensions:
    #        Behat\MinkExtension\ServiceContainer\MinkExtension:
    #            base_url:  http://suggester.dev
    #            files_path: features/attachments
    #            default_session: goutte
    #            javascript_session: selenium2

into file ``behat.yml`` than uncoment them

.. code-block:: yaml

    # behat.yml

    imports:
        resource: behat.yml.dist

    default:

        formatters:
             pretty: ~
             progress: false

        extensions:
            Behat\MinkExtension\ServiceContainer\MinkExtension:
                base_url:  http://suggester.dev
                files_path: features/attachments
                default_session: goutte
                javascript_session: selenium2

then customize ``base_url`` and other behat settings.

Running tests
=============

.. code-block:: bash

    $ bin/behat


