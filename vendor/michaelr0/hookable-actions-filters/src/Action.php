<?php

namespace Michaelr0\HookableActionsAndFilters;

class Action extends Hookable
{
    /**
     * REQUIRED IN EACH CHILD CLASS
     * Array of defined callback Listeners.
     *
     * @var array
     */
    protected static $listeners = [];
}
