<?php

namespace Michaelr0\HookableActionsAndFilters;

abstract class Hookable
{
    /**
     * REQUIRED IN EACH CHILD CLASS
     * Array of defined callback Listeners.
     *
     * @var array
     */
    protected static $listeners = [];

    /**
     * Fix listener ordering/priority.
     *
     * @param string $listener
     * @return void
     */
    protected static function ksort(string $listener)
    {
        if (isset(static::$listeners[$listener]) && count(static::$listeners[$listener]) > 1) {
            ksort(static::$listeners[$listener], SORT_NUMERIC);
        }
    }

    /**
     * Adds a new callback to the Listeners.
     *
     * @param string $listener
     * @param callable $callback
     * @param int $priority
     * @param int $arguments
     */
    public static function add(string $listener, callable $callback, int $priority = 10, int $arguments = 1)
    {
        $additionalListener = static::$listeners[$listener][$priority][] = [
            'callback' => $callback,
            'arguments' => $arguments,
        ];

        // Fix ordering/priority
        static::ksort($listener);

        return $additionalListener;
    }

    /**
     * Check existence of specified Listener.
     *
     * @param string $listener
     * @return bool
     */
    public static function exists(string $listener): bool
    {
        return isset(static::$listeners[$listener]);
    }

    /**
     * Check existence of specified Listener and Callback combination.
     *
     * @param string $listener
     * @param callable $callback
     * @return bool
     */
    public static function existsForCallback(string $listener, callable $callback): bool
    {
        foreach (static::$listeners[$listener] ?? [] as $priority) {
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
    public static function list(string $listener = null, int $priority = null): array
    {
        /**
         * If $listener is null, then list all listeners.
         */
        if (is_null($listener)) {
            // Return all listeners, sort listeners A - Z
            return collect(static::$listeners)->map(function ($item) {
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
            if (! empty(static::$listeners[$listener][$priority])) {
                // Listener/Priority was found, so lets output those results.
                return [
                    $listener => [
                        $priority => static::$listeners[$listener][$priority],
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
        if (! empty(static::$listeners[$listener])) {
            /*
             * $priority was defined, but this $hook did not match any listener.
             * Return results for this $listener, sort numeric priority ASC
             */
            return [
                $listener => collect(static::$listeners[$listener])->sortKeys()->toArray(),
            ];
        }

        /*
         * Return no results, because we had none to return.
         */
        return [];
    }

    /**
     * List ALL Listeners.
     * Shortcut to ::list().
     *
     * @return array
     */
    public static function listAll(): array
    {
        return static::list();
    }

    /**
     * Remove Listener / Callback combination.
     *
     * @param string $listener
     * @param callable $callback
     * @param int $priority
     * @param int $arguments
     */
    public static function remove(string $listener, callable $callback, int $priority = 10, int $arguments = 1)
    {
        foreach (static::$listeners[$listener][$priority] ?? [] as $key => $value) {
            if ($value['callback'] === $callback && $value['arguments'] === $arguments) {
                unset(static::$listeners[$listener][$priority][$key]);

                // Fix ordering/priority
                static::ksort($listener);

                break;
            }
        }
    }

    /**
     * Remove ALL Callbacks of a specified Listener.
     *
     * @param string $listener
     */
    public static function removeAllFor(string $listener)
    {
        unset(static::$listeners[$listener]);
    }

    /**
     * Run the specified listener.
     *
     * @param string $listener
     * @param mixed ...$args
     */
    public static function run(string $listener, ...$args)
    {
        $argsCount = count($args);

        foreach (static::$listeners[$listener] ?? [] as $priority) {
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
    }

    /**
     * Run the specified listener, then remove it.
     *
     * @param string $listener
     * @param mixed ...$args
     */
    public static function runOnce(string $listener, ...$args)
    {
        call_user_func_array([static::class, 'run'], func_get_args());
        static::removeAllFor($listener);
    }
}
