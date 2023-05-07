'use strict';
module.exports = function(grunt) {
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    concat: { 

      dist: {

          src: [
              'assets/js/plugins/*.js', // All JS in the libs folder
          ],
          
          dest: 'assets/js/plugins-min.js',
      }
    },

    uglify: {

      build: {
        src: ['assets/js/plugins/*.js'],
        dest: 'assets/js/plugins-min.js'
      }
    },

    autoprefixer: {
      options: {
        browsers: ['last 2 version', 'ie 8', 'ie 9']
      },
      no_dest: {
        src: 'style.css'
      },
    },

    watch: {

      js: {
        files: ['assets/js/plugins/*.js'],
        tasks: ['uglify']
      },

      css: {
        files: '**/*.scss',
        tasks: ['sass', 'autoprefixer'],
        options: {
          spawn: false,
          livereload: false
        }
      }
    },

    sass: {

      dist: {                            
        options: {                       
        style: 'expanded'
      },

      files: {                       
        'style.css': 'assets/sass/app.scss',
      }
     }
    },

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');

  // Default task(s).
  grunt.registerTask('default', ['concat', 'uglify', 'sass', 'autoprefixer']);
  
  grunt.registerTask('dev', [
    'watch'
  ]);

};