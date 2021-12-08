<?php

namespace App\Utils;

class Response {
    private int $status_code = 200;
    private $content;
    private array $headers = array('Content-Type: application/json');

    function __construct($content = null, $status_code = 200,  $headers = []) {
        $this->setStatusCode($status_code);
        $this->setHeaders($headers);
        $this->setContent($content);
    }

    public function setStatusCode($status_code): Response {
        $this->status_code = $status_code;
        return $this;
    }

    public function header($header): Response {
        $this->headers[] = $header;
        return $this;
    }

    public function setHeaders($headers): Response {
        foreach ($headers AS $header) $this->headers[] = $header;
        return $this;
    }

    public function setContent($content): Response {
        $this->content = $content;
        return $this;
    }

    public function json() {
        foreach ($this->headers AS $header) {
            header($header);
        }
        http_response_code($this->status_code);

        echo json_encode($this->content);
        die();
    }

    public function send() {
        foreach ($this->headers AS $header) {
            header($header);
        }
        http_response_code($this->status_code);

        echo $this->content;
        die();
    }
}