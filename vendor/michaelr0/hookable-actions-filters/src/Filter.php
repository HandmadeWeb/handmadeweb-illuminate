<?php

namespace Michaelr0\HookableActionsAndFilters;

class Filter extends Hookable
{
    /**
     * REQUIRED IN EACH CHILD CLASS
     * Array of defined callback Listeners.
     *
     * @var array
     */
    protected static $listeners = [];

    /**
     * Run the specified listener.
     *
     * @param string $listener
     * @param mixed ...$args
     * @return mixed
     */
    public static function run(string $listener, ...$args)
    {
        // set $value at start, as $arg0
        // example: run('test', $arg0, $arg1, $arg2)
        $value = $args[0] ?? null;

        $argsCount = count($args);

        foreach (static::$listeners[$listener] ?? [] as $priority) {
            foreach ($priority as $_listener) {
                // set $arg0 to $value at the start of each loop.
                // $value is then updated below and will be saved back to $arg0 on the next loop.
                $args[0] = $value;

                if ($_listener['arguments'] === 0) {
                    $value = call_user_func($_listener['callback']);
                } elseif ($_listener['arguments'] >= $argsCount) {
                    $value = call_user_func_array($_listener['callback'], $args);
                } else {
                    // Workaround if more args were passed than what the callback can accept
                    $value = call_user_func_array($_listener['callback'], array_slice($args, 0, $_listener['arguments']));
                }
            }
        }

        // Output $value, which has been filtered by each loop and callback.
        return $value;
    }

    /**
     * Run the specified listener, then remove it.
     *
     * @param string $listener
     * @param mixed ...$args
     * @return mixed
     */
    public static function runOnce(string $listener, ...$args)
    {
        $value = call_user_func_array([static::class, 'run'], func_get_args());
        static::removeAllFor($listener);

        // Output $value, which has been filtered by static::run($listener, $args).
        return $value;
    }
}
