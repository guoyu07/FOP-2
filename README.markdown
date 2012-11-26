FOP
=============

FOP is php wrapper for Apache FOP application. Generates pdf files using xsl template

Installation
------------

FOP should be installed using the [PEAR Installer](http://pear.php.net/). This installer is the backbone of PEAR, which provides a distribution system for PHP packages, and is shipped with every release of PHP since version 4.3.0.

The PEAR channel (`pear.sashabereka.com`) that is used to distribute FOP needs to be registered with the local PEAR environment:

    avb@ubuntu ~ % pear channel-discover pear.sashabereka.com
    Adding Channel "pear.sashabereka.com" succeeded
    Discovery of channel "pear.sashabereka.com" succeeded

This has to be done only once. Now the PEAR Installer can be used to install packages from the channel:

    avb@ubuntu ~ % pear install sashabereka/FOP

After the installation you can find the FOP source files inside your local PEAR directory;