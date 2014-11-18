<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <p>Normally shell macros can <strong>only</strong> be used in your twig files and there's no way to pass them to PHP so that you can use them.<br>
However, in some cases you may want to get for example the button classes that are set from the shell macros so that you may pass them to a filter in PHP.</p>

<p>For this reason we now have the <code>maera_get_echo()</code> function that you can use. It's a simple function that looks like this:</p>

<div class="highlight highlight-php"><pre><span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c"> * Return the value of an echo.</span></span>
<span class="pl-s2"><span class="pl-c"> * example: maera_get_echo( 'function' );</span></span>
<span class="pl-s2"><span class="pl-c"> */</span></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">maera_get_echo</span>( <span class="pl-vo">$function</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-s3">ob_start</span>();</span>
<span class="pl-s2">    $<span class="pl-vo">function</span>();</span>
<span class="pl-s2">    <span class="pl-vo">$get_echo</span> <span class="pl-k">=</span> <span class="pl-s3">ob_get_clean</span>();</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$get_echo</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span></pre></div>

<p>So in order to get the value of the buttons and pass them to the<code>example_filter</code> filter, you'll have to do the following:</p>

<div class="highlight highlight-php"><pre><span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c"> * Get the button classes from the edd-button-classes.twig file</span></span>
<span class="pl-s2"><span class="pl-c"> */</span></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">get_button_class</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-vo">$context</span> <span class="pl-k">=</span> <span class="pl-s3">Timber</span><span class="pl-k">::</span>get_context();</span>
<span class="pl-s2">    <span class="pl-s3">Timber</span><span class="pl-k">::</span>render( <span class="pl-s3">array</span>( <span class="pl-s1"><span class="pl-pds">'</span>button-classes.twig<span class="pl-pds">'</span></span>, ), <span class="pl-vo">$context</span>, apply_filters( <span class="pl-s1"><span class="pl-pds">'</span>maera/timber/cache<span class="pl-pds">'</span></span>, <span class="pl-c1">false</span> ) );</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">add_button_class</span>( <span class="pl-vo">$defaults</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-vo">$defaults</span>[<span class="pl-s1"><span class="pl-pds">'</span>class<span class="pl-pds">'</span></span>] <span class="pl-k">=</span>  maera_get_echo( <span class="pl-s1"><span class="pl-pds">'</span>get_button_class<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$defaults</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>example_filter<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>add_button_class<span class="pl-pds">'</span></span> );</span></pre></div>

<p>Don't forget to create the <code>button-classes.twig</code> file that you defined above!<br>
It should look something like this:</p>

<div class="highlight highlight-twig"><pre>{% <span class="pl-k">import</span> <span class="pl-s1"><span class="pl-pds">"</span>shell.html.twig<span class="pl-pds">"</span></span> <span class="pl-k">as</span> <span class="pl-vo">shell</span> %}
{{ shell.<span class="pl-vo">button_classes</span>( <span class="pl-s1"><span class="pl-pds">"</span>primary<span class="pl-pds">"</span></span>, <span class="pl-s1"><span class="pl-pds">"</span>large<span class="pl-pds">"</span></span> ) }}</pre></div>

    </div>

  </div>