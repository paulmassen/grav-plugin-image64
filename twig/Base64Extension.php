<?php

namespace Grav\Plugin;
use \Grav\Common\File;
use \Grav\Common\Grav;
use \Grav\Common\Page\Medium\ImageFile;
/**
 * Base64Extension class
 *
 * @author David Guyon <dguyon@gmail.com>
 * @link http://yoann.aparici.fr/post/18599782775/extension-twig-pour-encoder-les-images-en-base-64
 */
class Base64Extension extends \Twig_Extension
{
    private $webDir;

    /**
     * Constructor
     * Inject path to web directory
     *
     * @param string $webDir
     */
    public function __construct()
    {
         $this->config = Grav::instance()['config'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'image64' => new \Twig_Function_Method($this, 'image64'),
        );
    }

    /**
     * Return a base 64 encoded string only from image content type
     *
     * @param  string $path Path to image
     * @return string
     */
    public function image64($path)
    {
        $fullPath = $this->webDir.$path;
        $file = new ImageFile($fullPath, true);

        $binary = file_get_contents($fullPath);

        $split = explode('.', $file);
        $extension = end($split);
        return sprintf('data:image/%s;base64,%s', $extension, base64_encode($binary));
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'Base64Extension';
    }
    public function getFilters()
    {
        return array(
            'image64' => new \Twig_SimpleFilter('image64', array($this, 'image64')),
        );
        
    }
}