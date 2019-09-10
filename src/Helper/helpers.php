<?php
use Illuminate\Support\Facades\DB;

if (! function_exists('dddb')) {
    /**
     * Dump last query and exit.
     *
     * Needs query logging to be enabled.
     *
     * @return void
     */
    function dddb()
    {
        if (DB::logging()) {
            $queries = DB::getQueryLog();

            if ($queries) {
                $query_parts = end($queries);

                $query = $query_parts['query'];
                $bindings = $query_parts['bindings'];

                foreach ($bindings as $binding) {
                    if (is_numeric($binding)) {
                        $query = preg_replace('/\?/', $binding, $query, 1);
                    } else {
                        $query = preg_replace('/\?/', "'".$binding."'", $query, 1);
                    }
                }

                dd($query);
            } else {
                echo 'No Queries.'.PHP_EOL;
                die(1);
            }
        } else {
            echo 'Query logging is currently disabled.'.PHP_EOL;
            die(1);
        }
    }
}