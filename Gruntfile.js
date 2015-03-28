module.exports = function(grunt) {
    // initConfigの中に各タスクの設定を行っていきます。
    grunt.initConfig({ 
        // watchタスク: ファイルの変更を監視します。
        autoprefixer: {     // プレフィックスをつける
            target: {
                expand: true,
                src:  'public/assets/css/*.css',
                dest: './'
             },
             options: {
                // 対象ブラウザ
                browsers: ['last 2 version', 'ie 8', 'ie 9']
             }
        },
        cssmin: {           // CSSを圧縮
            target: {
                expand: true,
                // min.cssで終わっていないもの
                src: ['public/assets/css/*.css', '!*.min.css'],
                // 出力先はそのまま
                dest: './',
                // 拡張子を.min.cssに変更
                ext: '.min.css'
            },
        },
        uglify: {
            target: {
                files: [{
                    expand: true,
                    src: 'public/assets/js/*.js',
                    dest: './',
                }]
            }
        },
        imagemin: {
            target: {
                files: [{
                    expand: true,
                    src: ['public/assets/img/*.{png, jpg}', 'public/assets/img/*/*.{png, jpg}'],
                    dest: './',
                }]
            },
        },

        watch: {
            // ここにwatchタスクの設定を記述します。
            css: {
                files: ['public/assets/css/*.css'],
                tasks: ['autoprefixer', 'cssmin']
            },
            script: {
                files: ['public/assets/js/*.js'],
                tasks: ['uglify']
            },
            images: {
                files: ['public/assets/img/*.{png, jpg}', 'public/assets/img/*/*.{png, jpg}'],
                tasks: ['imagemin']
            }
        }
    });

    // grunt.loadNpmTasks('プラグイン名');でプラグインを読み込みます。
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // gruntコマンドのデフォルトタスクにwatchを追加します。
    grunt.registerTask('default', ['watch']);
};
