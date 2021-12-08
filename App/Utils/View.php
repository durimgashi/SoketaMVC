<?php

namespace App\Utils;


class View {

    private ?string $default_layout;
    private string $file_ext;
    private string $views_dir;
    private string $view;
    private array $variables = [];

    function __construct() {
        $this->default_layout = 'default.php';
        $this->file_ext = '.php';
        $this->views_dir = __DIR__.'/../Views';
    }

    public function render() {
        foreach ($this->variables as $key => $value) {
            $$key = $value;
        }

        if ($this->default_layout == null OR $this->default_layout == '') {
            include_once($this->views_dir . '/' . $this->view . $this->file_ext);
        } else {
            $layout = $this->views_dir . '/' . $this->view . $this->file_ext;
            include_once __DIR__.'../../Views/'.$this->default_layout;
        }
    }

    public function removeLayout(): View {
        $this->default_layout = null;
        return $this;
    }

    public function setDefaultLayout(string $default_layout): View {
        $this->default_layout = $default_layout;
        return $this;
    }

    public function setFileExt(string $file_ext): View {
        $this->file_ext = '.'.$file_ext;
        return $this;
    }

    public function setViewsDir(string $views_dir): View {
        $this->views_dir = $views_dir;
        return $this;
    }

    public function setView(string $view): View {
        $this->view = $view;
        return $this;
    }

    public function setVariable($variable_name, $value): View {
        $this->variables[$variable_name] = $value;
        return $this;
    }

    public function setVariables($variables): View {
        foreach ($variables AS $key => $value) {
            $this->variables[$key] = $value;
        }

        return $this;
    }
}