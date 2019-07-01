const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
//
// mix.js('resources/js/app.js', 'public/build/js')
//    .sass('resources/sass/app.scss', 'public/build/css');

mix.styles('resources/assets/css/global.css', 'public/build/css/global.css');
mix.styles('resources/assets/css/custom.css', 'public/build/css/custom.css');

mix.js('resources/assets/js/global.js', 'public/build/js/global.js');
mix.js('resources/assets/js/ResizeSensor.js', 'public/build/js/ResizeSensor.js');
mix.js('resources/assets/js/dashboard.js', 'public/build/js/dashboard.js');
mix.js('resources/assets/js/module/module.js', 'public/build/js/module/module.js');
mix.js('resources/assets/js/user/user.js', 'public/build/js/user/user.js');
mix.js('resources/assets/js/permission/permission.js', 'public/build/js/permission/permission.js');
mix.js('resources/assets/js/role/role.js', 'public/build/js/role/role.js');
mix.js('resources/assets/js/customer/customer.js', 'public/build/js/customer/customer.js');
//
const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins:
        [
            new WebpackShellPlugin({onBuildStart:['php artisan lang:js --quiet'], onBuildEnd:[]})
        ]
});
