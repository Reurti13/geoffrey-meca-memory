<?php

class Renderer
{
    /**
     * Affiche un template HTML en injectant les $variables
     *
     * @param  string $path
     * @param  array $variables
     * @return void
     */
    public static function render(string $path, array $variables = []): void
    {
        extract($variables);
        ob_start();
        require('templates/'. $path . '.html.php');
        $pageContent = ob_get_clean();

        require('templates/layout.html.php');
    }
}