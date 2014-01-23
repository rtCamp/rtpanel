'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    // Ref. https://npmjs.org/package/load-grunt-tasks
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Watch for hanges and trigger compass, jshint, uglify and livereload
        // Ref. https://npmjs.org/package/grunt-contrib-watch
        watch: {
            compass: {
                files: ['assets/rtpanel/**/*.{scss,sass}'],
                tasks: ['compass']
            },
            
            livereload: {
                options: {livereload: true},
                files: ['style.css', 'js/*.js', '*.html', '*.php', 'img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // SCSS and Compass
        // Ref. https://npmjs.org/package/grunt-contrib-compass
        compass: {
            dist: {
                options: {
                    config: 'config.rb',
                    force: true
                }
            }
        },

        // Fontello Icons
        fontello: {
            dist: {
                options: {
                    config: 'assets/fontello/config.json',
                    fonts: 'assets/fontello/font',
                    styles: 'assets/fontello/css',
                    scss: true,
                    // zip: 'test/output',
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

        // Concat
        // Note: This will concat all js files to single file to reduce http request
        // Ref. https://npmjs.org/package/grunt-contrib-concat
        concat: {
            options: {
                banner: '/*! \n\* Concat JS libraries to single js file to reduce http request.\n\* This will include modernizr.js, foundation.min.js and jquery.sidr.min.js \n\* \n\* @since rtPanel 4.1.4\n\*/ '
            },
            dist: {
                src: ['assets/foundation/bower_components/foundation/js/vendor/custom.modernizr.js', 'assets/foundation/bower_components/foundation/js/foundation.min.js', 'js/jquery.sidr.min.js'],
                dest: 'js/rtp-concat-lib.js'
            }
        },

        // WordPress Deployment
        // Ref. https://npmjs.org/package/grunt-wordpress-deploy
        wordpressdeploy: {
            options: {
                backup_dir: "backups/",
                rsync_args: ['-avz'],
                exclusions: ['Gruntfile.js', '.git/', 'tmp/*', 'backups/', 'wp-config.php', 'composer.json', 'composer.lock', 'README.md', '.gitignore', 'package.json', 'node_modules', '.sass-cache', 'npm-debug.log', '.scss-cache']
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

    // rename tasks
    // grunt.renameTask('rsync', 'deploy');

    // register task
    // grunt.registerTask('imagemin', ['imagemin']);

    // Fontello Fonts
    // grunt.registerTask('iconFonts', ['fontello']);

    // WordPress Deploy
    // grunt.registerTask('default', ['wordpressdeploy']);

    // Concat
    // grunt.registerTask('default', ['concat']);

    // register task
    grunt.registerTask('default', ['fontello', 'imagemin', 'concat', 'watch']);
};