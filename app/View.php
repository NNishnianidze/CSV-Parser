<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array $data = [],
        protected array $totals = [],
        protected float $totalPages = 1,
    ) {
    }

    public static function make(string $view, array $data = [], $totals = [], $totalPages = 1): static
    {
        return new static($view, $data, $totals, $totalPages);
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';
        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        /*foreach ($this->data as $key => $value) {
            $$key = $value;
        }*/

        ob_start();

        include $viewPath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /*public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }*/
}
