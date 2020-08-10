<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* app.html */
class __TwigTemplate_ba6baafb293f9e98a4fd6cc298927d1dc378bc90e5ea79618208da78cf37098f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content=\"IE=edge\"><meta name=viewport content=\"width=device-width,initial-scale=1\"><link rel=icon href=/favicon.ico><title>zoox</title><link rel=stylesheet href=\"https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900\"><link rel=stylesheet href=https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css><link href=/css/chunk-4671f6ee.6a47b58b.css rel=prefetch><link href=/css/chunk-62fffc2f.5bd79ce0.css rel=prefetch><link href=/css/chunk-78e4370e.7de652cb.css rel=prefetch><link href=/js/chunk-2d0c9395.9916e2e2.js rel=prefetch><link href=/js/chunk-2d0deaba.c290051e.js rel=prefetch><link href=/js/chunk-4671f6ee.fe0077f0.js rel=prefetch><link href=/js/chunk-62fffc2f.d0c92ad1.js rel=prefetch><link href=/js/chunk-78e4370e.55e933f5.js rel=prefetch><link href=/css/chunk-vendors.4ce633f7.css rel=preload as=style><link href=/js/app.68d93f63.js rel=preload as=script><link href=/js/chunk-vendors.056efd8e.js rel=preload as=script><link href=/css/chunk-vendors.4ce633f7.css rel=stylesheet></head><body><noscript><strong>We're sorry but zoox doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.056efd8e.js></script><script src=/js/app.68d93f63.js></script></body></html>";
    }

    public function getTemplateName()
    {
        return "app.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "app.html", "C:\\Users\\weverton.teodorak\\zoox-test\\resources\\templates\\app.html");
    }
}
