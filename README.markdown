FOP
=============

FOP is php wrapper for Apache FOP application. Generates pdf files using xsl template

Example
------------

    include_once('/path/to/library/FOP.php');
    // library configuration
    $config = array();
    // the only required parameter - path to xsl templates
    $config['templatesRoot'] = dirname(__FILE__).'/templates/';
    // optional parameter - path to apache fop application configuration. use it when you need custom fonts installation
    // $config['fopConfXMLRoot'] = dirname(__FILE__).'/fop.conf';
    // optional parameter - throw exceptions
    // $config['debug'] = true;
    // optional parameter - directory to store temporary xml files
    // $config['tmpRoot'] = ‘/tmp/’;
    // optional parameter - directory where fop utility installed
    // $config['pathToFOP'] = ‘/path/to/fop/’;
    
    $FOP = new FOP($config);
    $version = $FOP->getVersion();
    $is_installed = $FOP->isInstalled();
    $configuration = $FOP->getConfiguration();
    
    //var_dump($version);
    //var_dump($is_installed);
    //var_dump($configuration);
    
    $FOP
        ->setData('var', 'hello world') // add variable into xsl template
        ->setTemplateName('example.xsl') // name of xsl template to use
        ->renderAndFlush('report') // returns saved pdf document full path and flushes it. you can use render method in order just to save it
    ;

Installation
------------

Apache FOP installation is required (http://xmlgraphics.apache.org/fop/faq.html). On Ubuntu you can intall it with the following command

    avb@ubuntu ~ % sudo apt-get install fop

FOP should be installed using the [PEAR Installer](http://pear.php.net/). This installer is the backbone of PEAR, which provides a distribution system for PHP packages, and is shipped with every release of PHP since version 4.3.0.

The PEAR channel (`pear.sashabereka.com`) that is used to distribute FOP needs to be registered with the local PEAR environment:

    avb@ubuntu ~ % pear channel-discover pear.sashabereka.com
    Adding Channel "pear.sashabereka.com" succeeded
    Discovery of channel "pear.sashabereka.com" succeeded

This has to be done only once. Now the PEAR Installer can be used to install packages from the channel:

    avb@ubuntu ~ % pear install sashabereka/FOP

After the installation you can find the FOP source files inside your local PEAR directory;