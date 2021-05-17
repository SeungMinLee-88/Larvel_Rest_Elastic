<?php

use Illuminate\Container\Container;

function markdown($text) {
    return app(ParsedownExtra::class)->text($text);
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}

if (! function_exists('event')) {
    /**
     * Fire an event and call the listeners.
     *
     * @param  string|object  $event
     * @param  mixed  $payload
     * @param  bool  $halt
     * @return array|null
     */
    function event(...$args)
    {
        return app('events')->fire(...$args);
    }
}

if (! function_exists('icon')) {
    function icon($class, $addition = 'icon', $inline = null) {
        $icon   = config('icons.' . $class);
        $inline = $inline ? 'style="' . $inline . '"' : null;

        return sprintf('<i class="%s %s" %s></i>', $icon, $addition, $inline);
    }
}

if (! function_exists('attachment_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function attachment_path($path = '')
    {
        return public_path($path ? 'attachments'.DIRECTORY_SEPARATOR.$path : 'attachments');
    }
}
function gravatar_profile_url($email)
{
    return sprintf("//www.gravatar.com/%s", md5($email));
}
function api_request()
{
    $current = url()->current();
    return starts_with($current, 'http://localhost:8000/api/');
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

function link_for_filter($column, $text, $params = [])
{

    $direction = Request::input('noapprove');
    $approve = ($direction == 'y') ? 'n' : 'y';


        $text = sprintf(
            "%s %s",
            $direction == 'y' ? '<span class="glyphicon glyphicon-check"></span>' : '<span class="glyphicon glyphicon-unchecked"></span>',
            $text
        );
        if($approve === "y"){
    $queryString = http_build_query(array_merge(
        Request::except(['noapprove']),
        ['noapprove' => $approve],
        $params
    ));
        }else{
            $queryString = http_build_query(array_merge(
                Request::except(['noapprove']),$params));
        }
    return sprintf(
        '<a href="%s?%s">%s</a>',
        urldecode(Request::url()),
        $queryString,
        $text
    );
}
