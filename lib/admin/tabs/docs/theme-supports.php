<div id="wiki-body" class="gollum-markdown-content instapaper_body">
  <div class="markdown-body">
      <p>When building your own shell, you can activate parts of the Maera framework using theme supports.<br />
      Theme supports provide functionality and classes that you can use in your shells without requiring you to write your own code, thus taking advantage of Maera's structure.
      </p>

      <p>Theme supports are usually loaded using the <code>after_setup_theme</code> action.<br />
      In addition to the default <a href="http://codex.wordpress.org/Theme_Features">theme features</a> Kirki includes the following extra features:
      </p>

      <div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
          <span class="pl-s2"></span>
          <span class="pl-s2"><span class="pl-s">function</span> <span class="pl-enf">my_theme_supports</span>() {</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Add Kirki</span></span>
          <span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>kirki<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Add retina support</span></span>
          <span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>retina<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Add color calculations support</span></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Please note that this uses the 'jetpack_color' class.</span></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> More info on that class here: https://github.com/Automattic/jetpack/blob/master/_inc/lib/class.color.php</span></span>
          <span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>maera_color<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Add the tonesque library</span></span>
          <span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>tonesque<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">    <span class="pl-c"><span class="pl-pdc">//</span> Add site-logo support</span></span>
          <span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>site-logo<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2">}</span>
          <span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>after_setup_theme<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_theme_supports<span class="pl-pds">'</span></span> );</span>
          <span class="pl-s2"></span>
          <span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre>
      </div>

      <p>You can find the list of theme_supports provided by Maera below:</p>

      <h2>
          <a id="user-content-kirki" class="anchor" href="#kirki" aria-hidden="true"><span class="octicon octicon-link"></span></a>Kirki
      </h2>

      <p><a href="http://kirki.org">Kirki</a> is a wrapper for the WordPress customizer, making it easier for you to write your own customizer options and extend the default functionality.<br />
      To enable kirki support and include the kirki framework you can use<br />
      <code>add_theme_support( 'kirki' );</code><br />
      If the <a href="https://wordpress.org/plugins/kirki/">kirki plugin</a> plugin is not installed on the user's site, then we include this from inside the theme to reduce dependencies. </p>

      <h2>
      <a id="user-content-retina" class="anchor" href="#retina" aria-hidden="true"><span class="octicon octicon-link"></span></a>Retina</h2>

      <p>When you add theme support for retina images, the image resizing script will create some additional images with the suffix <strong>@2x</strong> and also enqueue the <a href="http://imulus.github.io/retinajs/">retina.js script</a> script.
      To enable retina support you can use<br />
      <code>add_theme_support( 'retina' );</code></p>

      <h2>
      <a id="user-content-color-calculations" class="anchor" href="#color-calculations" aria-hidden="true"><span class="octicon octicon-link"></span></a>Color calculations</h2>

      <p>If you need to do some color calculations performed, you can use Jetpack's color calculations class. If <a href="https://wordpress.org/plugins/jetpack/">Jetpack</a> is not installed, then we include this class on the theme core to reduce dependencies.<br />
      To include this feature you can use<br />
      <code>add_theme_support( 'maera_color' );</code></p>

      <h2>
      <a id="user-content-tonesque" class="anchor" href="#tonesque" aria-hidden="true"><span class="octicon octicon-link"></span></a>Tonesque</h2>

      <p>If you need to retrieve the main color of an image and perform calculations based on that color, you can use Jetpack's <a href="https://github.com/Automattic/jetpack/blob/master/_inc/lib/tonesque.php">Tonesque library</a>. If <a href="https://wordpress.org/plugins/jetpack/">Jetpack</a> is not installed, then we include this class on the theme core to reduce dependencies. Please note that when this is used, the color calculations class is also included.<br />
      To include this feature you can use<br />
      <code>add_theme_support( 'tonesque' );</code></p>

      <h2>
      <a id="user-content-site-logo" class="anchor" href="#site-logo" aria-hidden="true"><span class="octicon octicon-link"></span></a>Site Logo</h2>

      <p>Maera includes <a href="https://github.com/Automattic/site-logo">Automattic's site-logo plugin</a>. This way we're trying to standardize site logos usage across all shells. More documentation on this can be found on the <a href="https://github.com/Automattic/site-logo">plugin's repository</a>.
      To include this feature you can use<br />
      <code>add_theme_support( 'site-logo' );</code></p>
  </div>
</div>
