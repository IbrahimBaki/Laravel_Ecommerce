<?php

define('PAGINATION_COUNT', 15);

function getFolder()
{

    return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
}

function type($type)
{
    if ($type === 'main_category')
        $trans = 'main';
    elseif ($type === 'sub_category')
        $trans = 'sub';
    return $trans;

}

function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    return $filename;
}
