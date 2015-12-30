<?php
namespace Old\Milantex\Core;

class Application {
    private $configuration;
    private $routes;

    public function __construct(\Old\Milantex\Core\ConfigurationInterface $configuration, array $routes) {
        $this->configuration = $configuration;
        $this->routes = $routes;
    }

    public function run() {
        session_start();

        try {
            $database = new \Milantex\DAW\DataBase(
                $this->configuration::getDatabaseHostname(),
                $this->configuration::getDatabaseName(),
                $this->configuration::getDatabaseUsername(),
                $this->configuration::getDatabasePassword()
            );
        } catch (\PDOException $e) {
            echo 'Došlo je do greške prilikom uspostavljanja veze sa bazom podataka. Proverite parametre za vezu u konfiguracionoj datoteci Configuration.php.';
            exit;
        }

        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
        $rawUrl = filter_input(INPUT_GET, 'URL', FILTER_SANITIZE_STRING);
        $url = rtrim($rawUrl, '/');

        $context = new \Old\Milantex\Core\Context($url, $database);

        $selectedRoute = $this->routes[count($this->routes) - 1];

        foreach ($this->routes as $route) {
            if ($route->matches($method, $url)) {
                $selectedRoute = $route;
                break;
            }
        }

        $context->setTemplate('Main/index');
        $context->setBaseUrl($this->configuration::getWebsiteBaseUrl());

        $selectedRoute->execute($context);

        foreach ($context->getResponseHeaders() as $headerName => $headerValue) {
            header($headerName . ': ' . $headerValue);
        }

        if ($context->getTemplate() !== '') {
            (function(\Old\Milantex\Core\Context $Context) {
                define('BASE', $Context->getBaseUrl());

                require $this->configuration::getTemplatesFilesystemPath() . $Context->getTemplate() . '.php';
            })($context);
        }
    }
}
