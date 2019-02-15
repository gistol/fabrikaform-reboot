<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class AppExtension extends AbstractExtension
{
    private $imageDir;
    private $cacheManager;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper, string $imageDir)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
        $this->imageDir = $imageDir;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('filesize', [$this, 'formatFileSize']),
            new TwigFilter('image', [$this, 'imageFilter']),
        ];
    }

    /**
     * formatFileSize
     * Display file size in human readable format.
     */
    public function formatFileSize($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    /**
     * Image filters
     */
    public function imageFilter($path, $filter, array $runtimeConfig = array(), $resolver = null)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext === "svg") {
            return $this->imageDir . "/" . basename($path);
        } else {
            return $this->cacheManager->getBrowserPath($path, $filter, $runtimeConfig, $resolver);
        }

    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('getImageUrl', [$this, 'imageFunction'], ['is_safe' => ['html']]),
        );
    }

    public function imageFunction($obj, $size = false)
    {
        $path = $this->uploaderHelper->asset($obj, 'imageFile', null);

        if (!$size) {
            return $path;
        }

        try {
            return $this->cacheManager->getBrowserPath($path, $size, [], null);
        } catch (Exception $e) {
            return $path;
        }
    }
}
