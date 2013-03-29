<?php

namespace Maroon\RPGBundle\Menu;

use Knp\Menu\Renderer\ListRenderer;
use Knp\Menu\Renderer\RendererInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;

/**
 * Navigation menu renderer that extends ListRenderer to support Twitter Bootstrap navbar formatting.
 * Other menu types can also be crafted with this by changing the class of the root menu item:
 *
 * nav => navbar type
 * nav nav-tabs => tab bar type
 * nav nav-pills => pills type
 * nav nav-list => vertical list type
 *
 * nav-stacked can also be added to tab bars and pills to make them vertical. And dropdown submenus
 * should also work just fine with tabs and pills.
 */
class BootstrapNavRenderer extends ListRenderer implements RendererInterface
{
    public function __construct(MatcherInterface $matcher, $charset = null)
    {
        $defaultOptions = array(
            'depth' => null,
            'currentAsLink' => true,
            'currentClass' => 'active',
            'ancestorClass' => 'active',
            'firstClass' => '',
            'lastClass' => '',
            'compressed' => false,
            'allow_safe_labels' => true,
            'clear_matcher' => true,
        );

        parent::__construct($matcher, $defaultOptions, $charset);
    }

    /**
     * Called by the parent menu item to render this menu.
     *
     * This renders the li tag to fit into the parent ul as well as its
     * own nested ul tag if this menu item has children
     *
     * @param ItemInterface $item
     * @param array         $options The options to render the item
     *
     * @return string
     */
    protected function renderItem(ItemInterface $item, array $options)
    {
        // if we don't have access or this item is marked to not be shown
        if ( !$item->isDisplayed() ) {
            return '';
        }

        // create an array than can be imploded as a class list
        $class = (array) $item->getAttribute('class');

        if ( $this->matcher->isCurrent($item) || $this->matcher->isAncestor($item, $options['depth']) ) {
            $class[] = $options['currentClass'];
        }

        if ( $item->hasChildren() ) {
            if ( $item->getLevel() == 1 ) {
                $class[] = 'dropdown';
                $item->setLinkAttributes(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'))
                    ->setExtra('safe_label', true)
                    ->setLabel($item->getLabel() . ' <b class="caret"></b>')
                    ->setChildrenAttribute('class', 'dropdown-menu');
            } else {
                $class[] = 'dropdown-submenu';
                $item->setChildrenAttribute('class', 'dropdown-menu');
            }
        }

        if ( $icon = $item->getExtra('icon', false) ) {
            $item->setExtra('safe_label', true)
                ->setLabel("<i class=\"icon-$icon\"></i> " . $item->getLabel());
        }

        $isDivider = $item->getExtra('divider', false);
        if ( $isDivider ) {
            $class[] = 'divider';
        }

        $isHeader = $item->getExtra('header', false);
        if ( $isHeader ) {
            $class[] = 'nav-header';
        }

        // retrieve the attributes and put the final class string back on it
        $attributes = $item->getAttributes();
        if (!empty($class)) {
            $classAttr = trim(implode(' ', $class));
            if ( !empty($classAttr) ) {
                $attributes['class'] = $classAttr;
            }
        }

        // opening li tag
        $html = $this->format('<li'.$this->renderHtmlAttributes($attributes).'>', 'li', $item->getLevel(), $options);

        // if this is a divider, then do not render anything inside of it
        if ( !$isDivider && !$isHeader ) {
            // render the text/link inside the li tag
            //$html .= $this->format($item->getUri() ? $item->renderLink() : $item->renderLabel(), 'link', $item->getLevel());
            $html .= $this->renderLink($item, $options);

            // renders the embedded ul
            $childrenClass = (array) $item->getChildrenAttribute('class');
            $childrenClass[] = 'menu_level_'.$item->getLevel();

            $childrenAttributes = $item->getChildrenAttributes();
            $childrenAttributes['class'] = implode(' ', $childrenClass);

            $html .= $this->renderList($item, $childrenAttributes, $options);
        } else if ( $isHeader ) {
            // if it's a nav header, just render the label
            $html .= $this->renderLabel($item, $options);
        }

        // closing li tag
        $html .= $this->format('</li>', 'li', $item->getLevel(), $options);

        return $html;
    }
}
