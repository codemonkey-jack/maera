<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <p>Maera uses twig to handle a lot of its templating.
You can learn more about the twig syntax by taking a look at <a href="http://twig.sensiolabs.org/doc/templates.html">twig's templating documentation</a>.</p>

<p>An essential part of a shell is the <a href="http://twig.sensiolabs.org/doc/templates.html#macros">macros</a> we use throughout the other templates.
You will have to create a new file called <code>shell.html.twig</code> and Maera will automatically use it for its macro definitions.</p>

<p>You'll notice at some points that we include apply_filters and other WordPress-specific functions that don't normally exist on twig.
We are able to do that because we use the <a href="http://upstatement.com/timber/">Timber Library</a> to implement twig.</p>

<p>You can see the definitions that we have for the Core Shell here: <a href="https://github.com/presscodes/maera/blob/master/core-shell/shell.html.twig">https://github.com/presscodes/maera/blob/master/core-shell/shell.html.twig</a></p>

<p>You can simply copy-paste these to your own shell plugin and tweak them to suit your own needs.</p>

<p>Please note that even if you leave some of these empty, you will have to include them or specify fallbacks.</p>

    </div>

  </div>