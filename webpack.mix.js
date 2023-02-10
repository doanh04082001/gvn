const mix = require('laravel-mix');
const Fs = require('fs');
const Path = require('path');
const glob = require('glob');
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

const getFiles = path => {
    const files = []
    for (const file of Fs.readdirSync(path)) {
        const fullPath = path + '/' + file
        if (Fs.lstatSync(fullPath).isDirectory()) {
            getFiles(fullPath).forEach(x => files.push(file + '/' + x))
        } else {
            files.push(file)
        }
    }
    return files
};

Fs.copyFileSync(
    Path.resolve(process.env.MIX_FIREBASE_CLIENT_CREDENTIALS),
    './resources/js/firebase/firebase-client-credentials.json'
);

mix.js('resources/js/admin/app.js', 'public/assets/admin/js')
    .js('resources/js/modules/ckeditor.js', 'public/vendor/ckeditor')
    .js('resources/js/modules/firebase-messaging-sw.js', 'public')
    .js('resources/js/firebase/utils/helper.js', 'public/assets/admin/firebase/utils')
    .js('resources/js/firebase/utils/fcm-initial.js', 'public/assets/admin/firebase/utils')
    .vue()
    .copyDirectory('resources/js/admin/pages', 'public/assets/admin/js/pages')
    .copyDirectory('resources/js/admin/utils', 'public/assets/admin/js/utils')

// mix all admin files .scss
getFiles('resources/sass/admin')
    .filter(fileName => !fileName[0] != '_' && (/\.(scss)$/i).test(fileName))
    .forEach(fileName => mix.sass(
        `resources/sass/admin/${fileName}`,
        `public/assets/admin/css/${fileName.replace('.scss', '.css')}`
    ));

// Compile web.js and app.scss
mix.js('resources/js/web/web.js', 'public/assets/web/js/web.js')
    .sass('resources/sass/web/app.scss', 'public/assets/web/css')
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        {
                            loader: 'sass-loader',
                            options: {
                                additionalData: `
                                    @import "resources/sass/web/_variables.scss";
                                    @import "resources/sass/web/responsive.scss";
                                `
                            }
                        }
                    ],
                },
                {
                    test: /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/,
                    use: [
                        {
                            loader: 'file-loader',
                        }
                    ],
                }
            ]
        }
    });

// Compile all js files directly under the pages directory
glob.sync('resources/js/web/pages/*.js')
    .map( file => mix.js(file, 'public/assets/web/js/pages'));

// Compile all js files directly under the components directory
glob.sync('resources/js/web/components/*.js')
    .map( file=>mix.js(file, 'public/assets/web/js/components'));

// Compile all scss files directly under the pages directory
glob.sync('resources/sass/web/pages/*.scss')
    .map( file => mix.sass(file, 'public/assets/web/css/pages'));

// Compile all scss files directly under the components directory
glob.sync('resources/sass/web/components/*.scss')
    .map( file=> mix.sass(file, 'public/assets/web/css/components'));
