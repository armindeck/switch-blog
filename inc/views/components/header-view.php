<?php
/*
MIT License

Copyright (c) 2026 Armin Deck

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
?>
<!-- switch core v<?= core("version") ?> (<?= core("state") ?>) (Copyright © 2026 Armin Deck – Licencia de Uso No Transferible) – https://github.com/armindeck/switch -->
<!DOCTYPE html>
<html lang="<?= config("language") ?? "en" ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= config("name") ?? core("name") ?></title>
    <meta name="description" content="Listado de animes, peliculas, series">
    <style type="text/css">
        <?= file_exists(RAIZ . "style.css") ? file_get_contents(RAIZ . "style.css") : "" ?>
    </style>
    <?php foreach (["google", "important", "other"] as $value) { echo config("scripts")[$value]["enable"] ?? false === true && !empty(config("scripts")[$value]["script"]) ? config("scripts")[$value]["script"] . "\n" : ""; } ?>
</head>
<?php 
    $currentTheme = $_SESSION["theme"] ?? (!empty(config("theme")) ? config("theme") : "light");
    $themeClass = ($currentTheme !== "light") ? "theme-" . $currentTheme : "";
?>
<body class="<?= $themeClass ?>" data-theme="<?= $currentTheme ?>">
    <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <div class="app">
        <header class="header">
            <div>
                <h2 class="gradient-text"><?= config("name") ?? core("name") ?></h2>
            </div>
            <nav>
                <a href="<?= route() ?>">🏠 <?= language("home") ?></a>
                <a href="<?= route(!$auth ? "login" : "p/" . ($_SESSION["user"] ?? "")) ?>">👦 <?= language(!$auth ? "account" : "profile") ?></a>
                <a href="<?= route("community") ?>">👨‍👩‍👧‍👧 <?= language("community") ?></a>
                <label>🌓
                    <select name="config" id="config" onchange="window.location.href='?config='+this.value">
                        <option value="" selected><?= language("header.config") ?></option>
                        <optgroup label="<?= language("languages") ?>">
                            <?php foreach (core("languages") as $key): ?>
                            <option value="lang.<?= $key ?>"><?= strtoupper($key) ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="<?= language("themes") ?>">
                        <?php foreach (core("themes") as $key): ?>
                            <option value="theme.<?= $key ?>" <?= ($currentTheme === $key ? "selected" : "") ?>><?= str_replace(["-", "_"], " ", (strtoupper(substr($key, 0, 1)) . substr($key, 1, strlen($key)))) ?></option>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                </label>
                <?php if($auth && isset($view) && $view == "profile"): ?>
                    <a href="<?= route("logout") ?>">🚪 <?= language("logout") ?></a>
                <?php endif ?>
                <?php if($auth): ?>
                    <a href="<?= route("dashboard") ?>">📊 <?= language("dashboard") ?></a>
                <?php endif ?>
            </nav>
        </header>
        <?php if((!isset($view) || !in_array($view, ["dashboard", "profile", "login", "register", "forgot-password", "community", "settings"]))): ?>
            <?php if((config("ads")["moving"]["enable"] ?? false) == true): ?>
                <!-- Mensaje en movimiento -->
                <a href="<?= config("ads")["moving"]["url"] ?? "" ?>" <?= config("ads")["moving"]["new_tab"] ?? false ? "target=\"_blank\"" : "" ?> class="ads-move" style="display: flex; align-items: center; padding: 6px; font-weight: bold; border-top: 1px solid var(--content-border-strong-co); border-bottom: 1px solid var(--content-border-strong-co);">
                    <marquee direction="left" scrollamount="10" scrolldelay="145">
                        <?= config("ads")["moving"]["content"] ?? "" ?>
                    </marquee>
                </a>
            <?php endif; ?>
            <?php if((config("ads")["banner"]["enable"] ?? false) == true): ?>
                <!-- Banner de anuncio -->
                <a href="<?= config("ads")["banner"]["url"] ?? "" ?>" <?= config("ads")["banner"]["new_tab"] ?? false ? "target=\"_blank\"" : "" ?> class="ads-banner">
                    <img src="<?= config("ads")["banner"]["image"] ?? "" ?>" alt="<?= language("ads") ?>" style="width: 100%; height: auto;">
                </a>
            <?php endif; ?>
        <?php endif; ?>