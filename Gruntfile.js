'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    // Ref. https://npmjs.org/package/load-grunt-tasks
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Fontello Icons
        // Note: This is one time running task, so run grunt after update assets/fontello/config.json file
        // Ref. https://npmjs.org/package/grunt-fontello
        fontello: {
            dist: {
                options: {
                    config: 'assets/fontello/config.json',
                    fonts: 'assets/fontello/font',
                    styles: 'assets/fontello/css',
                    scss: true,
                    force: true
                }
            }
        },

        // Image Optimization
        // Note: This is one time running task, so run grunt after adding images in img/ folder
        // Ref. https://npmjs.org/package/grunt-contrib-imagemin
        imagemin: {
            dynamic: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                        expand: true,
                        cwd: 'img/',
                        src: ['**/*.{png,jpg,gif}'],
                        dest: 'img/'
                    }]
            }
        },

        // SCSS and Compass
        // Ref. https://npmjs.org/package/grunt-contrib-compass
        compass: {
            frontend: {
                options: {
                    config: 'config.rb',
                    force: true
                }
            },

            // Admin Panel CSS
            backend: {
                options: {
                    sassDir: 'admin/css/',
                    cssDir: 'admin/css/'
                }
            }
        },

        // Uglify
        // Compress and Minify JS files in js/rtp-main-lib.js
        // Ref. https://npmjs.org/package/grunt-contrib-uglify
        uglify: {
            options: {
                banner: '/*! \n * rtPanel JavaScript Library \n * @package rtPanel \n */'
            },
            build: {
                src: [
                    'assets/foundation/bower_components/foundation/js/vendor/modernizr.js',
                    'assets/foundation/bower_components/foundation/js/foundation.min.js',
                    'js/jquery.sidr.min.js',
                    'js/rtp-app.js'
                ],
                dest: 'js/rtp-package-min.js'
            }
        },

        // Watch for hanges and trigger compass and uglify
        // Ref. https://npmjs.org/package/grunt-contrib-watch
        watch: {
            compass: {
                files: ['**/*.{scss,sass}'],
                tasks: ['compass']
            },

            uglify: {
                files: '<%= uglify.build.src %>',
                tasks: ['uglify']
            }
        },

        // WordPress Deployment
        // Ref. https://npmjs.org/package/grunt-wordpress-deploy
        wordpressdeploy: {
            options: {
                backup_dir: "../../backups/",
                rsync_args: ['-avz'],
                exclusions: ['Gruntfile.js', '.bower.json', '.editorconfig', '.travis.yml', '.gitmodules', '.gitattributes', '.git/', '.svn/', 'tmp/*', 'wp-config.php', 'composer.json', 'composer.lock', '.gitignore', 'package.json', 'node_modules', '.sass-cache', 'npm-debug.log', '.scss-cache']
            },

            local: {
                "title": "local",
                "database": "database_name",
                "user": "database_username",
                "pass": "database_password",
                "host": "database_host",
                "url": "http://local_url",
                "path": "/local_path"
            },

            staging: {
                "title": "staging",
                "database": "database_name",
                "user": "database_username",
                "pass": "database_password",
                "host": "database_host",
                "url": "http://staging_url",
                "path": "/staging_path",
                "ssh_host": "user@staging_host"
            },

            final: {
                "title": "final",
                "database": "database_name",
                "user": "database_username",
                "pass": "database_password",
                "host": "database_host",
                "url": "http://final_url",
                "path": "/staging_path",
                "ssh_host": "user@staging_host"
            }
        }
    });

    // WordPress Deploy
    // grunt.registerTask('default', ['wordpressdeploy']);

    // Register Task
    grunt.registerTask('default', ['fontello', 'watch']);
};