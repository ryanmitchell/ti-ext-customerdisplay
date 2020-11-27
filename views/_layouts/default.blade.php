<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    {!! get_metas() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! get_favicon() !!}
    <title>{{ sprintf(lang('admin::lang.site_title'), Template::getTitle(), setting('site_name')) }}</title>
    {!! get_style_tags() !!}
</head>
<body class="page {{ $this->bodyClass }}">
    <div class="page-wrapper">
        <div class="page-content">
            {!! Template::getBlock('body') !!}
        </div>
    </div>

    {!! Assets::getJsVars() !!}
    {!! get_script_tags() !!}
</body>
</html>
