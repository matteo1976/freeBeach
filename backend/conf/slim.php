<?php

// vim: set ts=4 expandtab:

use \Monolog\Logger;
use \Monolog\Formatter\LineFormatter;
use \Monolog\Handler\StreamHandler;
use \Monolog\Handler\RotatingFileHandler;

function setupSlim() {
    $config = [
        'settings' => [
            'displayErrorDetails' => true,
            'addContentLengthHeader' => false,
            'logger' => [
                'name' => 'defaultLogger',
                'level' => \Monolog\Logger::DEBUG,
                // Log directory and file must be writable by the www-data group.
                // You may be required to manually setup file and dir to enable
                // logging. The path is relative to the index.php directory.
                'path' => '../../logs/sb_api.log',
            ],
        ],
    ];

    $app = new \Slim\App($config);

    // Setup the logger

    $app->getContainer()['logger'] = function(Slim\Container $c) {
        $formatter = new LineFormatter();
        $formatter->includeStacktraces(true);

        $handler = new StreamHandler($c['settings']['logger']['path'],
          $c['settings']['logger']['level']);
        $handler->setFormatter($formatter);

        //$handler = new RotatingFileHandler($c['settings']['logger']['path'],
        //    5, // Number of files
        //    $c['settings']['logger']['level']);

        $logger = new Logger($c['settings']['logger']['name']);
        $logger->pushHandler($handler);

        //$logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());

        return $logger;
    };

    // Setup the default error handler

    $app->getContainer()['errorHandler'] = function (Slim\Container $c) {
        return function ($request, $response, \Exception $exception) use ($c) {
            $c['logger']->error($exception->getMessage());

            return $c['response']->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write('Something went wrong!');
                //->write($exception->getMessage());
        };
    };

    // Setup PHP error handler for PHP v7
    $app->getContainer()['phpErrorHandler'] = function (Slim\Container $c) {
        return function ($request, $response, $error) use ($c) {
            $c['logger']->error($error);

            return $c['response']
                ->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write('Something went wrong!');
        };
    };

    return $app;
}

/*
 * The logger is stored in the Slim container and can be directly used
 * in routes as described below.
 *
 * $this->logger->addError('This is an error');
 * $this->logger->error('This also is an error');
 * $this->logger->info('This also is an info with some extra {0} {1}', [
 *      '0' => 'useful',
 *      '1' => 'parametric log']);
 * $this->logger->debug('Debug information');
 *
 * It is possible to log exceptions with full stack.
 * try {
 *     throw new Exception("due palle oh");
 * } catch(exception $e) {
 *     $this->logger->error($e);
 * }
 */
