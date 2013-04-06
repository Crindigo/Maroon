<?php

namespace Maroon\RPGBundle\Twig;

class MaroonExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'maroon_stat_bar' => new \Twig_Function_Method($this, 'statBar', ['is_safe' => ['html']]),
        );
    }

    public function statBar($type, $current, $max)
    {
        $typeUp = strtoupper($type);
        $curFmt = number_format($current);
        $maxFmt = number_format($max);

        $width = round(100 * $current / $max);
        $empty = 100 - $width;

        $spanStyle = '';
        if ( $current == 0 ) {
            $spanStyle = ' class="dead"';
        } else if ( $width <= 25 ) {
            $spanStyle = ' class="warning"';
        }

        return <<<HTML
<div class="progress progress-relative">
    <span title="$width%"$spanStyle>$typeUp: $curFmt / $maxFmt</span>
    <div class="bar bar-$type" style="width:$width%"></div>
    <div class="bar bar-empty" style="width:$empty%"></div>
</div>
HTML;

    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'maroon_extension';
    }
}