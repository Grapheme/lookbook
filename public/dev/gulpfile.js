/* jshint node:true */
'use strict';
// generated on 2014-12-25 using generator-gulp-webapp 0.2.0
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

var Live = true;

var onLive = function() {
  gulp.task('views', function () {
    return gulp.src('app/*.jade')
      .pipe($.jade({pretty: true}))
      .pipe(gulp.dest('.tmp'));
  });

  gulp.task('styles', function () {
    return gulp.src('app/styles/main.scss')
      .pipe($.plumber())
      .pipe($.rubySass({
        style: 'expanded',
        precision: 10
      }))
      .pipe($.autoprefixer({browsers: ['last 5 version']}))
      .pipe(gulp.dest('.tmp/styles'))
      .pipe(gulp.dest('../theme/styles'));
  });

  gulp.task('html', ['views', 'styles'], function () {
    var assets = $.useref.assets({searchPath: '{.tmp,app}'});

    return gulp.src(['app/*.html', '.tmp/*.html'])
      .pipe(assets)
      .pipe($.if('*.js', $.uglify()))
      .pipe($.if('*.css', $.csso()))
      .pipe(assets.restore())
      .pipe($.useref())
      //.pipe($.if('*.html', $.minifyHtml({conditionals: true, loose: true})))
      .pipe(gulp.dest('../theme'));
  });

  gulp.task('images', function () {
    return gulp.src('app/images/**/*')
      .pipe($.cache($.imagemin({
        progressive: true,
        interlaced: true
      })))
      .pipe(gulp.dest('../theme/images'));
  });

  gulp.task('fonts', function () {
    return gulp.src(require('main-bower-files')().concat('app/fonts/**/*'))
      .pipe($.filter('**/*.{eot,svg,ttf,woff}'))
      .pipe($.flatten())
      .pipe(gulp.dest('../theme/fonts'));
  });

  gulp.task('extras', function () {
    return gulp.src([
      'app/*.*',
      '!app/*.html',
      '!app/*.jade',
      'node_modules/apache-server-configs/dist/.htaccess'
    ], {
      dot: true
    }).pipe(gulp.dest('../theme'));
  });

  gulp.task('clean', require('del').bind(null, ['.tmp', '../theme']));

  gulp.task('connect', ['views', 'styles'], function () {
    var serveStatic = require('serve-static');
    var serveIndex = require('serve-index');
    var app = require('connect')()
      .use(require('connect-livereload')({port: 35729}))
      .use(serveStatic('.tmp'))
      .use(serveStatic('app'))
      .use('/bower_components', serveStatic('bower_components'))
      .use(serveIndex('app'));

    require('http').createServer(app)
      .listen(9000)
      .on('listening', function () {
        console.log('Started connect web server on http://localhost:9000');
      });
  });

  gulp.task('serve', ['connect', 'watch'], function () {
    require('opn')('http://localhost:9000');
  });

  // inject bower components
  gulp.task('wiredep', function () {
    var wiredep = require('wiredep').stream;

    gulp.src('app/styles/*.scss')
      .pipe(wiredep())
      .pipe(gulp.dest('app/styles'));

    gulp.src('app/**/*.jade')
      .pipe(wiredep())
      .pipe(gulp.dest('app'));
  });

  gulp.task('watch', ['connect'], function () {
    $.livereload.listen();

    // watch for changes
    gulp.watch([
      'app/*.html',
      '.tmp/*.html',
      '.tmp/styles/**/*.css',
      'app/scripts/**/*.js',
      'app/images/**/*',
      'app/*.jade',
    ]).on('change', $.livereload.changed);

    gulp.watch('app/**/*.jade', ['views']);
    gulp.watch('app/styles/**/*.scss', ['styles']);
    //gulp.watch('app/scripts/parts/*.js', ['scripts']);
    gulp.watch('bower.json', ['wiredep']);
  });

  gulp.task('build', ['views', 'html', 'images', 'fonts', 'extras', /*'scripts'*/], function () {
    return gulp.src('../theme/**/*').pipe($.size({title: 'build', gzip: true}));
  });

  gulp.task('default', ['clean'], function () {
    gulp.start('build');
  });

  // Handle the error
  function errorHandler (error) {
    console.log(error.toString());
    this.emit('end');
  }
}

var offLive = function() {
  gulp.task('views', function () {
    return gulp.src('app/*.jade')
      .pipe($.jade({pretty: true}))
      .pipe(gulp.dest('.tmp'));
  });

  gulp.task('styles', function () {
    return gulp.src('app/styles/main.scss')
      .pipe($.plumber())
      .pipe($.rubySass({
        style: 'expanded',
        precision: 10
      }))
      .pipe($.autoprefixer({browsers: ['last 5 version']}))
      .pipe(gulp.dest('.tmp/styles'));
  });

  /*var concat = require('gulp-concat');

  gulp.task('scripts', function() {
    return gulp.src('app/scripts/parts/*.js')
      .pipe(concat('app/scripts/main.concat.js'))
      .pipe(gulp.dest('../theme'));
  });
  */
  // gulp.task('jshint', function () {
  //   return gulp.src('app/scripts/**/*.js')
  //     .pipe($.jshint())
  //     .pipe($.jshint.reporter('jshint-stylish'))
  //     .pipe($.jshint.reporter('fail'));
  // });

  gulp.task('html', ['views', 'styles'], function () {
    var assets = $.useref.assets({searchPath: '{.tmp,app}'});

    return gulp.src(['app/*.html', '.tmp/*.html'])
      .pipe(assets)
      .pipe($.if('*.js', $.uglify()))
      .pipe($.if('*.css', $.csso()))
      .pipe(assets.restore())
      .pipe($.useref())
      //.pipe($.if('*.html', $.minifyHtml({conditionals: true, loose: true})))
      .pipe(gulp.dest('../theme'));
  });

  gulp.task('images', function () {
    return gulp.src('app/images/**/*')
      .pipe($.cache($.imagemin({
        progressive: true,
        interlaced: true
      })))
      .pipe(gulp.dest('../theme/images'));
  });

  gulp.task('fonts', function () {
    return gulp.src(require('main-bower-files')().concat('app/fonts/**/*'))
      .pipe($.filter('**/*.{eot,svg,ttf,woff}'))
      .pipe($.flatten())
      .pipe(gulp.dest('../theme/fonts'));
  });

  gulp.task('extras', function () {
    return gulp.src([
      'app/*.*',
      '!app/*.html',
      '!app/*.jade',
      'node_modules/apache-server-configs/dist/.htaccess'
    ], {
      dot: true
    }).pipe(gulp.dest('../theme'));
  });

  gulp.task('clean', require('del').bind(null, ['.tmp', '../theme']));

  gulp.task('connect', ['views', 'styles'], function () {
    var serveStatic = require('serve-static');
    var serveIndex = require('serve-index');
    var app = require('connect')()
      .use(require('connect-livereload')({port: 35729}))
      .use(serveStatic('.tmp'))
      .use(serveStatic('app'))
      // paths to bower_components should be relative to the current file
      // e.g. in app/index.html you should use ../bower_components
      .use('/bower_components', serveStatic('bower_components'))
      .use(serveIndex('app'));

    require('http').createServer(app)
      .listen(9000)
      .on('listening', function () {
        console.log('Started connect web server on http://localhost:9000');
      });
  });

  gulp.task('serve', ['connect', 'watch'], function () {
    require('opn')('http://localhost:9000');
  });

  // inject bower components
  gulp.task('wiredep', function () {
    var wiredep = require('wiredep').stream;

    gulp.src('app/styles/*.scss')
      .pipe(wiredep())
      .pipe(gulp.dest('app/styles'));

    gulp.src('app/**/*.jade')
      .pipe(wiredep())
      .pipe(gulp.dest('app'));
  });

  gulp.task('watch', ['connect'], function () {
    $.livereload.listen();

    // watch for changes
    gulp.watch([
      'app/*.html',
      '.tmp/*.html',
      '.tmp/styles/**/*.css',
      'app/scripts/**/*.js',
      'app/images/**/*',
      'app/*.jade',
    ]).on('change', $.livereload.changed);

    gulp.watch('app/**/*.jade', ['views']);
    gulp.watch('app/styles/**/*.scss', ['styles']);
    //gulp.watch('app/scripts/parts/*.js', ['scripts']);
    gulp.watch('bower.json', ['wiredep']);
  });

  gulp.task('build', ['views', 'html', 'images', 'fonts', 'extras', /*'scripts'*/], function () {
    return gulp.src('../theme/**/*').pipe($.size({title: 'build', gzip: true}));
  });

  gulp.task('default', ['clean'], function () {
    gulp.start('build');
  });

  // Handle the error
  function errorHandler (error) {
    console.log(error.toString());
    this.emit('end');
  }
}

Live ? onLive() : offLive();