<?php

namespace HandmadeWeb\Illuminate\Class\Abstract;

abstract class AbstractHookableClass
{
    /**
     * Array of defined callback Listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Adds a new callback to the Listeners.
     *
     * @param string $listener
     * @param callable $callback
     * @param int $priority
     * @param int $arguments
     * @return self
     */
    public function add(string $listener, callable $callback, int $priority = 10, int $arguments = 1): self
    {
        $this->listeners[$listener][$priority][] = [
            'callback' => $callback,
            'arguments' => $arguments,
        ];

        // Allow method chaining.
        return $this;
    }

    /**
     * Check existence of specified Listener.
     *
     * @param string $listener
     * @return bool
     */
    public function exists(string $listener): bool
    {
        return isset($this->listeners[$listener]);
    }

    /**
     * Check existence of specified Listener and Callback combination.
     *
     * @param string $listener
     * @param callable $callback
     * @return bool
     */
    public function existsForCallback(string $listener, callable $callback): bool
    {
        foreach ($this->listeners[$listener] ?? [] as $priority) {
            foreach ($priority as $_listener) {
                if ($_listener['callback'] === $callback) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * List Listeners.
     * Can return all listeners or a specific listener.
     *
     * @param string $listener
     * @param int $priority
     * @return array
     */
    public function list(string $listener = null, int $priority = null): array
    {
        /**
         * If $listener is null, then list all listeners.
         */
        if (is_null($listener)) {
            // Return all listeners, sort listeners A - Z
            return collect($this->listeners)->map(function ($item) {
                return collect($item)->sortKeys();
            })->toArray();

        /*
         * $listener was not null, so start looking for a specific listener.
         */
        } else {
            /**
             * If $priority has been defined
             * Check to see if it exists on the specified listener.
             */
            if (! empty($this->listeners[$listener][$priority])) {
                // Listener/Priority was found, so lets output those results.
                return [
                    $listener => [
                        $priority => $this->listeners[$listener][$priority],
                    ],
                ];

            /*
             * $priority was defined, but this $listener did not match any listener.
             * Return no results, because we had none to return.
             */
            } elseif (! is_null($priority)) {
                return [];
            }
        }

        /**
         * Check to see if this $listener is defined as a listener.
         */
        if (! empty($this->listeners[$listener])) {
            /*
             * $priority was defined, but this $hook did not match any listener.
             * Return results for this $listener, sort numeric priority ASC
             */
            return [
                $listener => collect($this->listeners[$listener])->sortKeys()->toArray(),
            ];
        }

        /*
         * Return no results, because we had none to return.
         */
        return [];
    }

    /**
     * List ALL Listeners.
     * Shortcut to ->list().
     *
     * @return array
     */
    public function listAll(): array
    {
        return $this->list();
    }

    /**
     * Remove Listener / Callback combination.
     *
     * @param string $listener
     * @param callable $callback
     * @param int $priority
     * @param int $arguments
     * @return self
     */
    public function remove(string $listener, callable $callback, int $priority = 10, int $arguments = 1): self
    {
        foreach ($this->listeners[$listener][$priority] ?? [] as $key => $value) {
            if ($value['callback'] === $callback && $value['arguments'] === $arguments) {
                unset($this->listeners[$listener][$priority][$key]);

                break;
            }
        }

        // Allow method chaining.
        return $this;
    }

    /**
     * Remove ALL Callbacks of a specified Listener.
     *
     * @param string $listener
     * @return self
     */
    public function removeAllFor(string $listener): self
    {
        unset($this->listeners[$listener]);

        // Allow method chaining.
        return $this;
    }

    /**
     * Run the specified listener.
     *
     * @param string $listener
     * @param mixed ...$args
     * @return self
     */
    public function run(string $listener, ...$args)
    {
        $argsCount = count($args);

        foreach ($this->listeners[$listener] ?? [] as $priority) {
            foreach ($priority as $_listener) {
                if ($_listener['arguments'] === 0) {
                    call_user_func($_listener['callback']);
                } elseif ($_listener['arguments'] >= $argsCount) {
                    call_user_func_array($_listener['callback'], $args);
                } else {
                    // Workaround if more args were passed than what the callback can accept
                    call_user_func_array($_listener['callback'], array_slice($args, 0, $_listener['arguments']));
                }
            }
        }

        // Allow method chaining.
        return $this;
    }

    /**
     * Run the specified listener, then remove it.
     *
     * @param string $listener
     * @param mixed ...$args
     * @return self
     */
    public function runOnce(string $listener, ...$args)
    {
        call_user_func_array([$this, 'run'], func_get_args());
        $this->removeAllFor($listener);

        // Allow method chaining.
        return $this;
    }
}
