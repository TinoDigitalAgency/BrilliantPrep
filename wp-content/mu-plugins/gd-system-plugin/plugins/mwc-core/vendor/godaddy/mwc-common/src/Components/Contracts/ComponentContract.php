<?php

namespace GoDaddy\WordPress\MWC\Common\Components\Contracts;

/**
 * A component represents functionality that can be loaded.
 *
 * Features are usually implemented as components or a collection of components loaded together.
 *
 * @since x.y.z
 */
interface ComponentContract
{
    /**
     * Initializes the component.
     *
     * @since x.y.z
     */
    public function load();
}
