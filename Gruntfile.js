module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/jquery-ui.js': 'jquery-ui/jquery-ui.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/requirejs.js': 'requirejs/require.js',
                    'js/backbone.js': 'backbone/backbone.js',
                    'js/underscore.js': 'underscore/underscore.js',
                    'js/gridster.js': 'gridster-js/dist/jquery.gridster.min.js',
                    'js/image-picker.js': 'image-picker/image-picker/image-picker.min.js',
                    'js/backbone.localStorage.js': 'backbone.localStorage/backbone.localStorage-min.js',
                    'js/backbone-nested.js': 'backbone-nested-model/backbone-nested.js',
                    'js/backbone-associations.js': 'backbone-associations/backbone-associations-min.js',
                    'js/select2.js': 'select2/dist/js/select2.min.js',
                    //pour le dashboard
                }
            },
            stylesheets: {
                files: {
//                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css',
                    'css/select2.css': 'select2/dist/css/select2.min.css',
                    'css/select2-bootstrap.css': 'select2-bootstrap-theme/dist/select2-bootstrap.min.css',
                }
            },
            fonts: {
                files: {
                    'fonts': ['font-awesome/fonts', 'bootstrap/fonts']
                }
            }


        },
        cssmin: {
            bundled: {
                src: 'web/assets/css/benagro.css',
                dest: 'web/assets/css/benagro.min.css'
            },
            dashboard: {
                src: 'web/assets/css/dashboard.css',
                dest: 'web/assets/css/dashboard.min.css'
            },
        },
        uglify: {
            options: {
                compress: {
                    drop_console: true
                }
            },
            js: {
                files: {
                    'web/assets/js/benagro.min.js': ['web/assets/js/benagro.js']
                }
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    //'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'src/AppBundle/Resources/public/css/*.css',
                    'web/assets/css/select2.css',
                    'web/assets/css/select2-bootstrap.css'
                ],
                dest: 'web/assets/css/benagro.css'
            },
            dashboardCSS: {
                src: "src/AppBundle/Resources/public/css/dashboard/*.css",
                dest: "web/assets/css/dashboard.css"
            },
            js: {
                src: [
                    'bower_components/jquery/dist/jquery.js',
                    'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    //'src/AppBundle/Resources/public/js/script.js',
//                    'web/bundles/fosjsrouting/js/router.js',
//                    'web/js/fos_js_routes.js'
                ],
                dest: 'web/assets/js/benagro.js'
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/images',
                src: '*',
                dest: 'web/assets/images/'
            },
            fonts: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/fonts',
                src: '*',
                dest: 'web/assets/fonts/'
            },
            js: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/js',
                src: ['*', '*/*', '*/*/*', '*/*/*/*'],
                dest: 'web/js/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy', 'copy', 'concat', 'cssmin', 'uglify']);
};