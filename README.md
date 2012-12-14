sfjqec
======

(english version below)
-----------------------

Questo bundle è la trasposizione in Symfony2 di un piccolo progetto, chiamato
[sfjqec](https://github.com/garak/sfjqec). È stato creato a scopo didattico, per una
presentazione tenuta inizialmente per il [PUG Roma](http://roma.grusp.org/) e poi
ampliata per il [phpDay](http://www.phpday.it/2011).
Lo scopo di questo codice è in generale mostrare come integrare correttamente
Javascript e PHP, con particolare riferimento a Symfony e jQuery.
Il progetto mostra un semplicissimo e-commerce, da cui il nome: sfjqec è formato da
sf (Symfony) + jq (jQuery) + ec (e-commerce).

in breve
--------

In estrema sintesi, questo progetto mostra come integrare correttamente Javascript e PHP,
usando AJAX. I passi sono i seguenti:

  * scrivere l'applicazione come se Javascript non esistesse
  * legare alcuni eventi (tipicamente click di link e submit di form) a delle funzioni
    Javascript
  * ciascuna di queste funzioni Javascript richiama uno script PHP, tramite AJAX
  * al successo della chiamata AJAX, richiama un'altra funzione Javascript, che si occupa
    di manipolare il DOM

Nello specifico di jQuery e Symfony, i passi si traducono nel seguente modo:

  * scrivere il controller normalmente
  * scrivere un file Javascript che usi l'evento `ready()` di jQuery e che faccia il `bind`
    dei click e dei submit necessari
  * usare l'evento passato da `bind` nella funzione Javascript per estrarre i riferimenti
    necessari dal DOM
  * nel controller, effettuare le necessarie modifiche (spesso basta modificare i redirect,
    in modo che NON siano effettuati per le richieste AJAX)
  * nella vista, aggiungere un file del tipo `NomeAzione.json.twig`
  * di nuovo nel file Javascript, scrivere la funzione che deve manipolare il DOM,
    basandosi sulla variabile `result`, che a questo punto contiene un oggetto JSON, che
    jQuery ricava dal codice della vista del punto precedente

A questo punto il mio consiglio è quello di analizzare i passi precedenti, tenendo
sott'occhio il codice di questo progetto, in particolare il controller e il file js.

installazione
-------------

Aggiungere le seguenti righe al proprio file `composer.json`:

``` json  
    "require": {
        "garak/demo-bundle": "dev-master"
    },
    "repositories": [{
        "type": "vcs",
        "url": "http://github.com/garak/GarakDemoBundle"
    }],
```

Abilitare il bundle nel kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Garak\DemoBundle\GarakDemoBundle(),
    );
}
```

Abilitare le rotte, aggiungendo nel file `app/config/routing.yml`:

``` yaml
GarakDemoBundle:
    resource: "@GarakDemoBundle/Controller/"
    type:     annotation
    prefix:   /demo/
```

Infine, eseguire da terminale lo script di aggiornamento:

``` bash
$ composer install
```


English version
---------------

This bundle is a conversion in Symfony2 of a small project, named
[sfjqec](https://github.com/garak/sfjqec).
It has been created for learning purpose, for a
presentation held a first time for [PHP User Group Roma](http://roma.grusp.org/) and then, in a
wider format, for [phpDay](http://www.phpday.it/2011).
The purpose of this code is showing how to integrate in a proper way Javascript e PHP,
with specific references to Symfony and jQuery.
The project shows a very simple e-commerce site, so it's called "sfjqec": 
sf (Symfony) + jq (jQuery) + ec (e-commerce).

in short
--------

The correct way to integrate Javascript and PHP, with AJAX, is divided in 4 steps:

  * write app as if Javascript wouldn't exist
  * tie some events (link clicks and form submits, tipically) to Javascript functions
  * each of such functions recall a PHP script, via AJAX
  * when AJAX call succeeds, Javascript calls another function, that deals with DOM
    manipulation

With jQuery and symfony, the steps are translated like follow:

  * write a standard controller
  * write a Javascript file using jQuery's `ready()` event, doing a `bind` of clicks
    and submits, where needed
  * use event passed by `bind` in Javascript function and extract needed references
    from DOM
  * in the controller, do the needed adaptations (often all you need is to change
    redirects, so they are NOT executed for AJAX requests)
  * in the view, add a file like `ActionName.json.twig`
  * again in Javascript file, write a function to manipolate DOM, based on `result`
    variabile, that is currently containing a JSON object, elaborated by jQuery from
    the view

My advice is to analyze those steps, while looking to project code, mainly the controller
and the js file.

installation
------------

Add the following lines in your `composer.json` file:

``` json  
    "require": {
        "garak/demo-bundle": "dev-master"
    },
    "repositories": [{
        "type": "vcs",
        "url": "http://github.com/garak/GarakDemoBundle"
    }],
```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Garak\DemoBundle\GarakDemoBundle(),
    );
}
```

Enable routes, adding to `app/config/routing.yml` file:

``` yaml
GarakDemoBundle:
    resource: "@GarakDemoBundle/Controller/"
    type:     annotation
    prefix:   /demo/
```

Last, update vendors from a terminal:

``` bash
$ composer install
```
