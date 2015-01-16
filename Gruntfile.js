/**
 * Created by elinnilsson on 30/12/14.
 */

module.exports = function (grunt) {
   grunt.initConfig(
      {
         pkg: grunt.file.readJSON('package.json'),
         concat: {
            options: {
               separator: ';',
               sourceMap: true,
               sourceMapStyle: 'link'
            },
            dist: {
               src: [
                  'Public/css/Foundation/js/vendor/modernizr.js',
                  'Public/css/Foundation/js/vendor/fastclick.js',
                  'Public/Scripts/Vendor/JQuery/jquery-1.11.2.js',
                  'Public/Scripts/Vendor/JQuery/jquery-ui.js',
                  'Public/Scripts/Vendor/JQuery/jquery.fileupload.js',
                  'Public/Scripts/Vendor/Angular/angular.js',
                  'Public/Scripts/Vendor/Angular/angular-messages.js',
                  'Public/Scripts/Vendor/Angular/Plugins/angular-resource.js',
                  'Public/Scripts/Vendor/Angular/Plugins/angular-route.js',
                  'Public/Scripts/Vendor/Angular/Plugins/angular-cookies.js',
                  'Public/Scripts/Vendor/JQuery/jquery.iframe-transport.js',
                  'Public/Scripts/Vendor/JQuery/jquery.fileupload-process.js',
                  'Public/Scripts/Vendor/JQuery/jquery.fileupload-angular.js',
                  'Public/Scripts/app.js',
                  'Public/Scripts/Factories/*.js',
                  'Public/Scripts/Directives/*.js',
                  'Public/Scripts/Directives/FormValidation/*.js',
                  'Public/Scripts/Directives/Parsers/*.js',
                  'Public/Scripts/Filters/*.js',
                  'Public/Scripts/Services/*.js',
                  'Public/Scripts/Controllers/*.js'
               ],
               dest: 'dist/<%= pkg.name %>.js'
            }
         },
         concat_sourcemap: {
            options: {
               sourcesContent: true,
               stripBanners: true
            },
            target: {
               files: {
                  'dest/default_options.js': [
                     'Public/css/Foundation/js/vendor/modernizr.js',
                     'Public/css/Foundation/js/vendor/fastclick.js',
                     'Public/Scripts/Vendor/JQuery/jquery-1.11.2.js',
                     'Public/Scripts/Vendor/JQuery/jquery-ui.js',
                     'Public/Scripts/Vendor/JQuery/jquery.fileupload.js',
                     'Public/Scripts/Vendor/Angular/angular.js',
                     'Public/Scripts/Vendor/Angular/angular-messages.js',
                     'Public/Scripts/Vendor/Angular/Plugins/angular-resource.js',
                     'Public/Scripts/Vendor/Angular/Plugins/angular-route.js',
                     'Public/Scripts/Vendor/Angular/Plugins/angular-cookies.js',
                     'Public/Scripts/Vendor/JQuery/jquery.iframe-transport.js',
                     'Public/Scripts/Vendor/JQuery/jquery.fileupload-process.js',
                     'Public/Scripts/Vendor/JQuery/jquery.fileupload-angular.js',
                     'Public/Scripts/app.js',
                     'Public/Scripts/Factories/*.js',
                     'Public/Scripts/Directives/*.js',
                     'Public/Scripts/Directives/FormValidation/*.js',
                     'Public/Scripts/Directives/Parsers/*.js',
                     'Public/Scripts/Filters/*.js',
                     'Public/Scripts/Services/*.js',
                     'Public/Scripts/Controllers/*.js'
                  ]
               }
            }
         },
         uglify: {
            options: {
               banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */ \n',
               sourceMap: true,
               sourceMapIncludeSources: true
//               sourceMapIn: 'dist/<%= pkg.name %>.min.js.map' // TODO It should not be needed to include both full .js and min.js in html to get proper source map. That's the case right now. Future Elin can fix it.
            },
            dist: {
               files: {
                  'dist/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
               }
            }
         }
      }
   );

   grunt.loadNpmTasks('grunt-concat-sourcemap');
   grunt.loadNpmTasks('grunt-contrib-uglify');
   grunt.loadNpmTasks('grunt-contrib-concat');

   // the default task can be run just by typing "grunt" on the command line
   grunt.registerTask('default', ['concat', 'uglify']);
};