<?php
namespace Codelab;

class Error
{
    public function runtime(string $message, string $description = null)
    {
        $theme = new Theme();
        $theme->get('errorRuntime', ['message' => $message, 'description' => $description]);
        die();
    }
}
