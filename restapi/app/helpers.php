<?php

if (! function_exists('icon')) {
    function icon($class, $addition = 'icon', $inline = null) {
        $icon   = config('icons.' . $class);
        $inline = $inline ? 'style="' . $inline . '"' : null;

        return sprintf('<i class="%s %s" %s></i>', $icon, $addition, $inline);
    }
}

function link_for_sort($column, $text, $params = [])
{

    $direction = Request::input('sortmethod');
    $reverse = ($direction == 'asc') ? 'desc' : 'asc';

    if (Request::input('sortfield') == $column) {
        $text = sprintf(
            "%s %s",
            $direction == 'asc' ? icon('asc') : icon('desc'),
            $text
        );
    }
    $queryString = http_build_query(array_merge(
        Request::except(['page', 'sortfield', 'sortmethod']),
        ['sortfield' => $column, 'sortmethod' => $reverse],
        $params
    ));
    return sprintf(
        '<a href="%s?%s">%s</a>',
        urldecode(Request::url()),
        $queryString,
        $text
    );
}
