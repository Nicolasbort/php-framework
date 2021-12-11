<?php

namespace MedDocs\Core;

abstract class AbstractMiddleware
{
    abstract public function handle(): bool;
}