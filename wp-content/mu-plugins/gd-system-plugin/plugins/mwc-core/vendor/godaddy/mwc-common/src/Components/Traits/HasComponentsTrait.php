<?php

namespace GoDaddy\WordPress\MWC\Common\Components\Traits;

use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ConditionalComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Exceptions\ComponentClassesNotDefinedException;
use GoDaddy\WordPress\MWC\Common\Components\Exceptions\ComponentLoadFailedException;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;

/**
 * Common functionality for classes that need to load one or more components.
 *
 * @since x.y.z
 */
trait HasComponentsTrait
{
    /**
     * Gets an array of fully qualified names of components classes to instantiate.
     *
     * @since x.y.z
     *
     * @return array
     */
    protected function getComponentClasses() : array
    {
        if (! property_exists($this, 'componentClasses')) {
            throw new ComponentClassesNotDefinedException(get_class($this).' must define a componentClasses property with a list of component classes to instantiate.');
        }

        return ArrayHelper::wrap($this->componentClasses);
    }

    /**
     * Instantiates all registered components.
     *
     * @since x.y.z
     *
     * @throws ComponentLoadFailedException
     */
    protected function loadComponents()
    {
        foreach ($this->getComponentClasses() as $className) {
            if ($component = $this->maybeInstantiateComponent($className)) {
                $component->load();
            }
        }
    }

    /**
     * Attempts to create an instance of the given class name.
     *
     * Throws an exception if the given class name is not a component.
     *
     * @since x.y.z
     *
     * @param string $className the name of the class to instantiate
     *
     * @return ComponentContract|null
     * @throws ComponentLoadFailedException
     */
    protected function maybeInstantiateComponent(string $className)
    {
        if (! is_a($className, ComponentContract::class, true)) {
            throw new ComponentLoadFailedException("{$className} does not implement the ComponentContract interface.");
        }

        if (is_a($className, ConditionalComponentContract::class, true) && ! $className::shouldLoad()) {
            return null;
        }

        return new $className();
    }
}
