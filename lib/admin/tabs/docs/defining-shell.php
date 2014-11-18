<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <p>Maera makes it easy to create new shells.</p>

<p>The recommended method to create a new shell is by writing a custom WordPress plugin.</p>

<p>File structure of a shell plugin:</p>

<pre><code>├── assets
|   └── Stylesheets and scripts
├── views
|   └── shell-specific templates
├── class-Maera_Example.php
├── shell.html.twig
└── shell.php
</code></pre>

<p>The first step will be to create our main plugin file. In this case we will call this file shell.php<br>
It would be best if you could keep the same file structure in your own shells to ensure better consistency.</p>

<div class="highlight highlight-php"><pre><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-k">&lt;</span>?<span class="pl-c1">php</span></span>
<span class="pl-s2"><span class="pl-c">/*</span></span>
<span class="pl-s2"><span class="pl-c">Plugin Name:         Example Shell</span></span>
<span class="pl-s2"><span class="pl-c">Description:         This is just an example of hw to build a shell plugin for the Maera theme</span></span>
<span class="pl-s2"><span class="pl-c">Version:             0.1</span></span>
<span class="pl-s2"><span class="pl-c">Author:              me</span></span>
<span class="pl-s2"><span class="pl-c">Author URI:          http://example.com</span></span>
<span class="pl-s2"><span class="pl-c">*/</span></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-s3">define</span>( <span class="pl-s1"><span class="pl-pds">'</span>MAERA_EXAMPLE_SHELL_URL<span class="pl-pds">'</span></span>, plugins_url( <span class="pl-s1"><span class="pl-pds">'</span><span class="pl-pds">'</span></span>, <span class="pl-c1">__FILE__</span> ) );</span>
<span class="pl-s2"><span class="pl-s3">define</span>( <span class="pl-s1"><span class="pl-pds">'</span>MAERA_EXAMPLE_SHELL_PATH<span class="pl-pds">'</span></span>, <span class="pl-s3">dirname</span>( <span class="pl-c1">__FILE__</span> ) );</span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-c">// Include our shell class.</span></span>
<span class="pl-s2"><span class="pl-k">require_once</span> <span class="pl-c1">MAERA_EXAMPLE_SHELL_PATH</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>/class-Maera_Example.php<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c"> * Include the shell</span></span>
<span class="pl-s2"><span class="pl-c"> */</span></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">maera_shell_example_include</span>( <span class="pl-vo">$shells</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">// Add our shell to the array of available shells</span></span>
<span class="pl-s2">    <span class="pl-vo">$shells</span>[] <span class="pl-k">=</span> <span class="pl-s3">array</span>(</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// Alphanumeric (lowercase name of our shell)</span></span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>value<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>example<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// The full name of our shell.</span></span>
<span class="pl-s2">        <span class="pl-c">// This will be used in the shell selection option in the dashboard</span></span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>label<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>Example<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2"></span>
<span class="pl-s2">        <span class="pl-c">// The name of our Shell Class.</span></span>
<span class="pl-s2">        <span class="pl-c">// We're going to include everything concerning our shell there.</span></span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>class<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>Maera_Example_Shell<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2"></span>
<span class="pl-s2">    );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$shells</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2"><span class="pl-c">// Add our shell to the list of available shells</span></span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/shells/available<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>maera_shell_bootstrap_include<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>


    </div>

  </div>