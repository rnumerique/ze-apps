<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function str_ends_with($haystack, $needle)
{
    return strrpos($haystack, $needle) + strlen($needle) === strlen($haystack);
}

function clearCache()
{
    rrmdir(FCPATH . 'assets/cache');
    return true;
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object))
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        rmdir($dir);
    }
    return true;
}

function recursive_mkdir($dirName)
{
    if (!is_dir($dirName)) {
        mkdir($dirName, 0777, true);
    }
}

function r_mvdir($src, $dst)
{
    if (is_dir($src)) {
        $dir_handle = opendir($src);
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (is_dir($src . "/" . $file)) {
                    if (!is_dir($dst . "/" . $file)) {
                        recursive_mkdir($dst . "/" . $file);
                    }
                    if (!r_mvdir($src . "/" . $file, $dst . "/" . $file)) {
                        return false;
                    }
                } else {
                    if (!copy($src . "/" . $file, $dst . "/" . $file)) {
                        return false;
                    }
                }
            }
        }
        closedir($dir_handle);
    } else {
        if (!copy($src, $dst)) {
            return false;
        }
    }
    return true;
}

function minifyCss($css)
{
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

    // Remove space after colons
    $css = str_replace(array(': ', ' :', ' {', '{ ', ' }', '} '), array(':', ':', '{', '{', '}', '}'), $css);

    // Remove whitespace
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}

function minifyJs($js)
{ // NOT WORKING, DO NOT USE
    // Remove comments
    $js = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $js);

    // Remove space after colons
    $js = str_replace(': ', ':', $js);

    // Remove space before equal signs
    $js = str_replace(' =', '=', $js);

    // Remove space after equal signs
    $js = str_replace('= ', '=', $js);

    // Remove whitespace
    $js = str_replace(array("\r\n\r\n", "\n\n", "\r\r", '\t', '  ', '    ', '    '), '', $js);

    return $js;
}

function formatNumber($num, $size, $padded = false)
{

    if ($size > strlen($num) && $padded) {
        $padded = str_pad($num, $size, '0', STR_PAD_LEFT);
    } else {
        $padded = substr($num, -$size);
    }

    return $padded;
}