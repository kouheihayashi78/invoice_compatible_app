<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        <!-- inertiaを使用する上で必要なメタデータやリンクなどを動的に挿入するタグ -->
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- フロントエンドのエントリポイント作成のタグ、アプリのメインjs(app.jsなど)が読み込まれ実行される -->
        <!-- つまりPagesディレクトリで作成したvueファイルをimportしたapp.jsの内容をここで表示することができる -->
        @inertia
    </body>
</html>
