<?php
namespace Old\Milantex\Core;

class Context {
    private $urlArguments;
    private $responseHeaders;
    private $responseContent;
    private $data;
    private $template;
    private $database;
    private $baseUrl;

    public function __construct(string $requestUrl, \Milantex\DAW\DataBase &$database) {
        $this->urlArguments = explode('/', $requestUrl);

        $this->responseHeaders = [
            'content-type' => 'text/html; charset=utf-8'
        ];

        $this->responseContent = '';

        $this->data = [];

        $this->template = 'Main/index';

        $this->database = $database;
    }

    public function getUrlArguments(): array {
        return $this->urlArguments;
    }

    public function getUrlArgument(int $index): ?string {
        return $this->urlArguments[$index] ?? null;
    }

    public function setResponseHeader(string $name, string $value) {
        $this->responseHeaders[strtolower($name)] = $value;
    }

    public function removeResponseHeader(string $name, string $value) {
        unset($this->responseHeaders[strtolower($name)]);
    }

    public function getResponseHeader(string $name) : ?string {
        return $this->responseHeaders[strtolower($name)] ?? null;
    }

    public function getResponseHeaders() : array {
        return $this->responseHeaders;
    }

    public function setResponseContent(string $content) {
        $this->responseContent = $content;
    }

    public function getResponseContent() {
        return $this->responseContent ?? '';
    }

    public function setData(string $name, $value) {
        $this->data[$name] = $value;
    }

    public function clearData(string $name) {
        unset($this->data[$name]);
    }

    public function getData(): array {
        return $this->data;
    }

    public function get(string $dataKey) {
        return $this->data[$dataKey] ?? '';
    }

    public function setTemplate(string $template) {
        $this->template = $template;
    }

    public function getTemplate(): string {
        return $this->template;
    }

    public function &getDatabase(): \Milantex\DAW\DataBase {
        return $this->database;
    }

    public function setBaseUrl(string $baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl(): string {
        return $this->baseUrl;
    }
}
