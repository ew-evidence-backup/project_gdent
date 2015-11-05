<?php

// add functions in seperate 'functions/*.php' files
foreach(glob(plugin_dir_path(__FILE__) . "functions/*.php") as $file) {
    include_once $file;
}