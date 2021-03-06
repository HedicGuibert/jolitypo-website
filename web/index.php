<?php

include "../vendor/autoload.php";

use JoliTypo\Fixer;

$fixers = array(
    'Dash' => 'Fix ndash &amp; mdash',
    'Dimension' => 'Replace the letter x between numbers',
    'Ellipsis' => 'Fix the ...',
    'SmartQuotes' => '“ Smart Quote for the selected language ”',
    'FrenchNoBreakSpace' => 'Set non breaking spaces before `:`, `;`, `!` and `?`',
    'NoSpaceBeforeComma' => 'Remove spaces before `,`',
    'Hyphen' => 'Automatic word-hyphenation',
    'CurlyQuote' => 'Replace straight quotes by curly one’s',
    'Trademark' => 'Handle symbol like ™ © ®',
    'Numeric' => 'Add non breaking spaces for units',
);

$locales = array('en_GB', 'fr', 'af_ZA', 'ca', 'da_DK', 'de_AT', 'de_CH', 'de_DE', 'en_UK', 'et_EE', 'hr_HR',
    'hu_HU', 'it_IT', 'lt_LT', 'nb_NO', 'nn_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sr', 'zu_ZA');
$selectedFilters = array('Ellipsis', 'Dimension', 'Numeric', 'Dash', 'SmartQuotes', 'NoSpaceBeforeComma', 'CurlyQuote', 'Hyphen', 'Trademark');
$toFixContent = "";
$fixedContent = "";

if (isset($_POST['content']) && isset($_POST['fixers']) && !empty($_POST['fixers'])) {
    $selectedFilters = array_keys(array_intersect_key(array_filter($_POST['fixers']), $fixers));
    $selectedLocale = in_array($_POST['locale'], $locales) ? $_POST['locale'] : $locales[0];
    $toFixContent = $_POST['content'];

    $fixer = new Fixer($selectedFilters);
    $fixer->setLocale($selectedLocale);
    $fixedContent = $fixer->fix($_POST['content']);
}

?><!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>JoliTypo demo - Micro-typography fixer for HTML contents</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/highlight/default.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/main.css">

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">JoliTypo demo</a>
        </div>
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>JoliTypo - Web Microtypography fixer</h1>
        <p>Paste your HTML content, set the fixers you want to run, grab the result and PROFIT§!!</p>
        <p><a class="btn btn-primary btn-lg" href="https://github.com/jolicode/JoliTypo" role="button">See on Github &raquo;</a></p>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <form role="form" method="post" action="">
            <div class="col-md-4">
                <h2>Fixers</h2>

                <div class="form-group">
                    <label for="locale">Locale (for SmartQuote and Hyphen)</label>
                    <select id="locale" name="locale" class="form-control">
                        <?php foreach ($locales as $locale): ?>
                            <option value="<?php echo $locale; ?>"><?php echo $locale; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="locale">Fixers to apply</label>
                    <?php foreach ($fixers as $fixerName => $help): ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1"
                                       <?php if (in_array($fixerName, $selectedFilters)): ?>
                                           checked="checked"
                                       <?php endif; ?>
                                       name="fixers[<?php echo $fixerName; ?>]"> <?php echo $fixerName; ?>
                            </label>
                            <p class="help-block"><?php echo $help; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-8">
                <h2>Your content</h2>

                <div class="form-group">
                    <textarea class="form-control" name="content"
                              placeholder="<p>My old school HTML content</p>"
                              rows="<?php echo count($fixers) * 2; ?>"><?php echo $toFixContent; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">FIX YOUR CONTENT MICROTYPOGRAPHY NOW!!</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Result</h2>
            <?php if (!empty($fixedContent)): ?>
                <pre><code class="html"><?php echo htmlentities($fixedContent); ?></code></pre>
            <?php else: ?>
                <p>Submit some content, and be amazed!</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($fixedContent)): ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Diff</h2>

                <pre id="diff"></pre>
            </div>
        </div>
    <?php endif; ?>

    <hr>

    <footer>
        <!-- Thx Pascal! -->
        <p>&copy; <a href="https://github.com/jolicode/JoliTypo">JoliTypo</a> is brought to you by <a href="http://jolicode.com">JoliCode</a>.</p>
        <p>This is a PHP script parsing your HTML and trying to fix commons typography issues, it's open-source and under MIT License.</p>
    </footer>
</div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>

<script src="js/vendor/highlight.pack.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/vendor/diff.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script>
    var one = <?php echo json_encode($toFixContent, JSON_UNESCAPED_UNICODE); ?>;
    var other = <?php echo json_encode($fixedContent, JSON_UNESCAPED_UNICODE); ?>;

    var diff = JsDiff.diffChars(one, other);
    var display = document.getElementById('diff')

    diff.forEach(function(part){
        // green for additions, red for deletions
        // grey for common parts
        var color = part.added ? 'green' :
            part.removed ? 'red' : 'black';
        var span = document.createElement('span');
        span.style.color = color;
        span.appendChild(document.createTextNode(part.value));
        display.appendChild(span);
    });
</script>
<script src="js/main.js"></script>
</body>
</html>
