<?php

namespace Maroon\RPGBundle\Modifier;

use Symfony\Component\Finder\Finder;

class ModifierCollector
{
    public function collectCategory($category)
    {
        $modifiers = [];
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/' . $category);

        /** @var $file \SplFileInfo */
        foreach ( $finder as $file ) {
            $className = $file->getBasename('.php');
            $class = '\Maroon\RPGBundle\Modifier\\' . $category . '\\' . $className;
            if ( class_exists($class) ) {
                $mod = new $class();
                if ( is_subclass_of($mod, '\Maroon\RPGBundle\Modifier\AbstractModifier') ) {
                    $modifiers[] = $mod;
                }
            }
        }

        return $modifiers;
    }

    public function collectAll()
    {
        $categories = $this->getCategories();
        $all = [];
        foreach ( $categories as $cat ) {
            $all[$cat->getFilename()] = $this->collectCategory($cat->getFilename());
        }
        return $all;
    }

    public function getCategories()
    {
        $finder = new Finder();
        $finder->directories()->in(__DIR__);
        return iterator_to_array($finder);
    }
}