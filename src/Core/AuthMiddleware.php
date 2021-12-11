<?php

namespace MedDocs\Core;

class AuthMiddleware extends AbstractMiddleware
{
    public function handle(): bool
    {
        $user = $_SESSION['user'] ?? null;

        if (!isset($user)) {
            return false;
        }

        return true;
    }
}