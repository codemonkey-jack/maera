<div id="wiki-body" class="gollum-markdown-content instapaper_body">
<div class="markdown-body">
<p>When building your own shell, you can activate parts of the Maera framework using theme supports.<br>
Theme supports provide functionality and classes that you can use in your shells without requiring you to write your own code, thus taking advantage of Maera's structure.  </p>

<p>Theme supports are usually loaded using the <code>after_setup_theme</code> action.<br>
In addition to the default <a href="http://codex.wordpress.org/Theme_Features">theme features</a> Kirki includes the following extra features:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_theme_supports</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">// Add breadcrumbs support.</span></span>
<span class="pl-s2">    <span class="pl-c">// prompts for the installation of the Breadcrumb Trail plugin: https://wordpress.org/plugins/breadcrumb-trail/</span></span>
<span class="pl-s2">    <span class="pl-c">// You will then have to configure them using this as an example: https://github.com/justintadlock/breadcrumb-trail#breadcrumb-trail</span></span>
<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>breadcrumbs<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">// Add Less Compiler support</span></span>
<span class="pl-s2">    <span class="pl-c">// Prompts the user to install the compiler plugin: https://wordpress.org/plugins/lessphp/</span></span>
<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>less_compiler<span class="pl-pds">'</span></span> )</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">// Add SASS/SCSS Compiler support</span></span>
<span class="pl-s2">    <span class="pl-c">// Prompts the user to install the compiler plugin: https://wordpress.org/plugins/lessphp/</span></span>
<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>sass_compiler<span class="pl-pds">'</span></span> )</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>after_setup_theme<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_theme_supports<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

</div>

</div>
