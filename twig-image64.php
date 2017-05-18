<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class TwigImage64Plugin
 * @package Grav\Plugin
 */
class TwigImage64Plugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }

    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $this->enable([
            'onTwigExtensions' => ['onTwigExtensions', 0],
        ]);
    }

    public function onTwigExtensions()
    {
        require_once(__DIR__ . '/twig/Base64Extension.php');
        $this->grav['twig']->twig->addExtension(new Base64Extension());
    }

}
