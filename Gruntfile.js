module.exports = function(grunt) {

  var jsFileList = [
    'app/webroot/js/components/jquery/dist/jquery.min.js',
    'app/webroot/js/components/angular/angular.min.js',
    'app/webroot/js/components/angular-mask/dist/ngMask.min.js'
  ];

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      js: {
        options: {
          separator: '\n;'
        },
        src: jsFileList,
        dest: 'app/webroot/js/scripts.js'
      }
    },
  });

  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.registerTask('default', ['concat']);

}