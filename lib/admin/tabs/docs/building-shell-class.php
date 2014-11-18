<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <p>Our main shell class will contain all the functionality of our shell. We will be loading our stylesheets, sripts and anything else required by our shell here.</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c">* The Shell</span></span>
<span class="pl-s2"><span class="pl-c">*/</span></span>
<span class="pl-s2"><span class="pl-st">class</span> <span class="pl-en">Maera_Framework_Core</span> {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-s">private</span> <span class="pl-s">static</span> <span class="pl-vo">$instance</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-s">private</span> <span class="pl-st">function</span> <span class="pl-s3">__construct</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">        do_action( <span class="pl-s1"><span class="pl-pds">'</span>maera/shell/include_modules<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// CAUTION: DO NOT DELETE THIS.</span></span>
<span class="pl-s2">        <span class="pl-k">if</span> ( <span class="pl-k">!</span> <span class="pl-s3">defined</span>( <span class="pl-s1"><span class="pl-pds">'</span>MAERA_SHELL_PATH<span class="pl-pds">'</span></span> ) ) {</span>
<span class="pl-s2">            <span class="pl-s3">define</span>( <span class="pl-s1"><span class="pl-pds">'</span>MAERA_SHELL_PATH<span class="pl-pds">'</span></span>, <span class="pl-s3">dirname</span>( <span class="pl-c1">__FILE__</span> ) );</span>
<span class="pl-s2">        }</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// Define our compiler.</span></span>
<span class="pl-s2">        <span class="pl-vo">$compiler</span> <span class="pl-k">=</span> <span class="pl-c1">null</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// Enqueue the scripts</span></span>
<span class="pl-s2">        add_action( <span class="pl-s1"><span class="pl-pds">'</span>wp_enqueue_scripts<span class="pl-pds">'</span></span>, <span class="pl-s3">array</span>( <span class="pl-vo">$this</span>, <span class="pl-s1"><span class="pl-pds">'</span>scripts<span class="pl-pds">'</span></span> ), <span class="pl-c1">110</span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// Add the shell Timber modifications</span></span>
<span class="pl-s2">        add_filter( <span class="pl-s1"><span class="pl-pds">'</span>timber_context<span class="pl-pds">'</span></span>, <span class="pl-s3">array</span>( <span class="pl-vo">$this</span>, <span class="pl-s1"><span class="pl-pds">'</span>timber_extras<span class="pl-pds">'</span></span> ) );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c">     * This is required to instantianate our shell</span></span>
<span class="pl-s2"><span class="pl-c">     */</span></span>
<span class="pl-s2">    <span class="pl-s">public</span> <span class="pl-s">static</span> <span class="pl-st">function</span> <span class="pl-en">get_instance</span>() {</span>
<span class="pl-s2">        <span class="pl-k">if</span> ( <span class="pl-c1">null</span> <span class="pl-k">==</span> <span class="pl-st">self</span><span class="pl-k">::</span><span class="pl-vo">$instance</span> ) {</span>
<span class="pl-s2">            <span class="pl-st">self</span><span class="pl-k">::</span><span class="pl-vo">$instance</span> <span class="pl-k">=</span> <span class="pl-k">new</span> <span class="pl-st">self</span>;</span>
<span class="pl-s2">        }</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-k">return</span> <span class="pl-st">self</span><span class="pl-k">::</span><span class="pl-vo">$instance</span>;</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c">     * Register all scripts and additional stylesheets (if necessary)</span></span>
<span class="pl-s2"><span class="pl-c">     */</span></span>
<span class="pl-s2">    <span class="pl-st">function</span> <span class="pl-en">scripts</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">        wp_register_style( <span class="pl-s1"><span class="pl-pds">'</span>example-css<span class="pl-pds">'</span></span>, <span class="pl-c1">MAERA_EXAMPLE_SHELL_URL</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>/assets/css/style.css<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2">        wp_enqueue_style( <span class="pl-s1"><span class="pl-pds">'</span>example-css<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">        wp_register_script( <span class="pl-s1"><span class="pl-pds">'</span>example-js<span class="pl-pds">'</span></span>, <span class="pl-c1">MAERA_EXAMPLE_SHELL_URL</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>/assets/js/main.js<span class="pl-pds">'</span></span>, <span class="pl-c1">false</span>, <span class="pl-c1">null</span>, <span class="pl-c1">false</span> );</span>
<span class="pl-s2">        wp_enqueue_script( <span class="pl-s1"><span class="pl-pds">'</span>example-js<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c">     * Timber extras.</span></span>
<span class="pl-s2"><span class="pl-c">     */</span></span>
<span class="pl-s2">    <span class="pl-st">function</span> <span class="pl-en">timber_extras</span>( <span class="pl-vo">$data</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>singular<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>switch<span class="pl-pds">'</span></span>] <span class="pl-k">=</span> <span class="pl-c1">true</span>;</span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>singular<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>width<span class="pl-pds">'</span></span>]  <span class="pl-k">=</span> <span class="pl-c1">550</span>;</span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>singular<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>height<span class="pl-pds">'</span></span>] <span class="pl-k">=</span> <span class="pl-c1">300</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>archives<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>switch<span class="pl-pds">'</span></span>] <span class="pl-k">=</span> <span class="pl-c1">true</span>;</span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>archives<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>width<span class="pl-pds">'</span></span>]  <span class="pl-k">=</span> <span class="pl-c1">550</span>;</span>
<span class="pl-s2">        <span class="pl-vo">$data</span>[<span class="pl-s1"><span class="pl-pds">'</span>archives<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>image<span class="pl-pds">'</span></span>][<span class="pl-s1"><span class="pl-pds">'</span>height<span class="pl-pds">'</span></span>] <span class="pl-k">=</span> <span class="pl-c1">300</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-k">return</span> <span class="pl-vo">$data</span>;</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<p>The above contains the basics of a shell and is just an example.</p>

<p><strong>Lines 10-28:</strong> Add any actions &amp; filters we may be using. This is where you'll probably be executing any custom functions that you add to this class. These are executed as soon as the class is intantianatied.<br>
<strong>Lines 33-39:</strong> We use the singleton pattern to instantianate our classes, so this is necessary. Also requires line 8: <code>private static $instance;</code><br>
<strong>Lines 44-52:</strong> Enqueue our stylesheets and scripts.<br>
<strong>Lines 57-68:</strong> Include any customizations that our shell requires to handle our twig template files.</p>

    </div>
  </div>