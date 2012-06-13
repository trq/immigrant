<?php

desc('Run the unit tests');
task('tests', function($args) {
    $report = ' ';
    if (isset($args['coverage'])) {
        if (!is_dir('tests/coverage')) {
            mkdir('tests/coverage');
        }
        $report = ' --coverage-html tests/coverage ';
    }
    if (isset($args['verbose'])) {
        system('phpunit' . $report . '--colors --debug --verbose --configuration tests/phpunit.xml');
    } else {
        system('phpunit' . $report . '--colors --configuration tests/phpunit.xml');
    }
});

task('default', 'tests');
