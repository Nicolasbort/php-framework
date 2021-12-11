<?php
namespace MedDocs\Core;
class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if (!$position) {
            return $path;
        }

        $path = substr($path, 0, $position);

        return $path;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getQuery(): array
    {
        $queryString = $_SERVER['QUERY_STRING'] ?? null;
        $queryArray = [];

        if (!$queryString) {
            return $queryArray;
        }

        parse_str($queryString, $queryArray);

        return $queryArray;
    }

    public function getBody(): array
    {
        $body = [];

        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}