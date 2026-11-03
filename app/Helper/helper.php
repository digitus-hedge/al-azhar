
<?php

use Illuminate\Support\Str;

if (!function_exists('asset')) {

    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function asset($path, $secure = null) {
        return app('url')->asset('public/' . $path, $secure);
    }

}
?>
