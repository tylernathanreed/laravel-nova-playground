let mix = require('laravel-mix')

mix.setPublicPath('dist')
   .js('resources/js/action-gearbox.js', 'js')
   .sass('resources/sass/action-gearbox.scss', 'css')
