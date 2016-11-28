var desktopVendorScripts = [
  'assets/js/vendor/jquery/jquery.hoverIntent.js',
  'assets/js/vendor/jquery/superfish.js'
];

var desktopScripts = [
  'assets/js/desktop/**/*.js'
];

var vcScripts = [
  'assets/js/vc_extend/**/*.js'
];

// NOTE: declare these prior to setting up NPM concat

// -- only scripts to be js hinted
var jsHintScripts = [];
jsHintScripts = jsHintScripts.concat( desktopScripts, vcScripts );

// -- combine scripts
var desktopScripts = desktopVendorScripts.concat( desktopScripts );




var compass   = require('gulp-compass');
var concat    = require('gulp-concat');
var gulp      = require('gulp');
var sass      = require('gulp-sass');
var uglify    = require('gulp-uglify');
var jshint    = require('gulp-jshint');


function swallowError (error) {
  console.log(error.toString());
  this.emit('end');
}



gulp.task('build-css', ['compass'], function(){
  return true;
});

gulp.task('build-js', ['concat-js'], function(){
  return true;
});



gulp.task('watch', function() {
  gulp.watch('assets/sass/**/*.scss', ['build-css']);
  gulp.watch('assets/js/desktop/**/*.js', ['build-js']);
});


gulp.task('default', ['watch'] );





/********************************************************/
/*****************   Worker Methods  ********************/
/********************************************************/




/* Compass and Sass */
/********************************************************/

gulp.task('compass', function() {

  var compassConfig = {
    config_file: 'assets/sass/sass-config.rb',
    css: 'assets/dist',
    sass: 'assets/sass'
  };

  var sassConfig = { outputStyle: 'compressed' };

  var source = 'assets/sass/desktop.scss';
  var destination = 'assets/dist/';
  var desktop = gulp.src( source )
    .pipe(
      compass( compassConfig )
    )
    .on( 'error', swallowError )
    .pipe( gulp.dest( destination ) );

  return desktop;
});


// this process concats some compiled css files.
// I do this rather than include the SASS file so that I can load the styles in the order I want
// gulp.task('css', ['compass'], function(){

//   var destination = "assets/css/";

//   //-- desktop
//   var source = [
//     './wwwroot/assets/js/vendor/jquery.uniform/themes/custom/css/uniform.default.css',
//     './wwwroot/assets/js/vendor/jquery.modal/jquery.modal.css',
//     './wwwroot/assets/css/desktop.css'
//   ];
//   var desktop = gulp.src( source )
//     .pipe( concat('desktop.css', { newLine: '' } ))
//     .pipe( gulp.dest( destination ) );

//   // return the merged streams
//   return desktop
// });


/* Javascript */
/********************************************************/

gulp.task('jshint', function() {

  var hinted = gulp.src( jsHintScripts )
    .pipe( jshint('.jshintrc') )
    .pipe( jshint.reporter('jshint-stylish') );

  return hinted;

});

gulp.task('concat-js', ['jshint'], function(){
  var destination = "assets/dist/";
  var devDestination = "assets/js/bundled/";
  var desktop = gulp.src( desktopScripts )
    .pipe( concat('desktop.js') )
    .pipe( gulp.dest( devDestination ) )
    .pipe( uglify() )
    .pipe( gulp.dest( destination ) )
    .on( 'error', swallowError );

  return desktop;
});

