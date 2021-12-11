<?php
namespace MedDocs\Core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    public function setFlash(string $key, string $message, string $color = 'primary'): void
    {
      $_SESSION[self::FLASH_KEY][$key] = [
          'value' => $message,
          'color' => $color,
          'remove' => false
      ];
    }

    public function getFlash(string $key): ?array 
    {
        return $_SESSION[self::FLASH_KEY][$key] ?? null;
    }

    public function setSession(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}