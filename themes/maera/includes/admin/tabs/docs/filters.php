<div id="wiki-body" class="gollum-markdown-content instapaper_body">
<div class="markdown-body">
<h3>
<a id="user-content-maeraadminoptions" class="anchor" href="#maeraadminoptions" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/admin/options</h3>

<p>This filter will add items to the Admin Theme Options page.</p>

<p>You may want to use this filter to add aditional options. However, theme specific customization options should use the customizer and not the options page.</p>

<h3>
<a id="user-content-maeracontainer_class" class="anchor" href="#maeracontainer_class" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/container_class</h3>

<p>This filter will change or add the class to the main container.
You may want to use this filter to change the width of the container or to append a certain CSS class.</p>

<p>Example:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_container_class</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-vo">$class_setting</span> <span class="pl-k">=</span> get_theme_mod( <span class="pl-s1"><span class="pl-pds">'</span>my_theme_mod<span class="pl-pds">'</span></span>,<span class="pl-c1">1</span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">if</span> ( <span class="pl-vo">$class_setting</span>  <span class="pl-k">==</span> <span class="pl-c1">1</span> ) {</span>
<span class="pl-s2">        <span class="pl-c">// Bootstrap responsive fixed container class.</span></span>
<span class="pl-s2">        <span class="pl-vo">$main_class</span> <span class="pl-k">=</span> <span class="pl-s1"><span class="pl-pds">'</span>container<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2">    } <span class="pl-k">else</span> {</span>
<span class="pl-s2">        <span class="pl-c">// Bootstrap fluid full-width container class.</span></span>
<span class="pl-s2">        <span class="pl-vo">$main_class</span> <span class="pl-k">=</span> <span class="pl-s1"><span class="pl-pds">'</span>container-fluid<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$main_class</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/container_class<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>maera_container_class<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maeracontent_width" class="anchor" href="#maeracontent_width" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/content_width</h3>

<p>You may want to use this filter to change the default width of the container.</p>

<p>Example:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_content_width</span>() {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">if</span> ( <span class="pl-k">!</span> <span class="pl-s3">isset</span>( <span class="pl-vo">$content_width</span> ) ) {</span>
<span class="pl-s2">        <span class="pl-vo">$content_width</span> <span class="pl-k">=</span> <span class="pl-c1">960</span>;</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$content_width</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/content_width<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>maera_<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maeraimageheight" class="anchor" href="#maeraimageheight" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/image/height</h3>

<p>You may want to use this filter to change the height of featured images. This may be useful when creating fluid, concise layouts.</p>

<p>Example: Set the height of featured images to 200px</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_featured_images_height</span>() {</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-c1">200</span>;</span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>maera/image/height<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_featured_images_height<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maeraimagewidth" class="anchor" href="#maeraimagewidth" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/image/width</h3>

<p>You may want to use this filter to change the width of featured images. This may be useful when creating fluid, concise layouts.</p>

<p>Example: Set the width of featured images to 450px</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_featured_images_width</span>() {</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-c1">450</span>;</span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>maera/image/height<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_featured_images_width<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maerasection_classprimary" class="anchor" href="#maerasection_classprimary" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/section_class/primary</h3>

<p>Allows you to add classes to the primary sidebar.</p>

<p>Example:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_sidebar_primary_classes</span>( <span class="pl-vo">$class</span> ) {</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$class</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span> primary col-sm-6 col-md-4 col-lg-3<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>maera/section_class/primary<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_sidebar_primary_classes<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maerasection_classsecondary" class="anchor" href="#maerasection_classsecondary" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/section_class/secondary</h3>

<p>Allows you to add classes to the secondary sidebar. Usage is exactly the same as the <a href="#maerasection_classprimary">maera/section_class/primary</a> action.</p>

<h3>
<a id="user-content-maerasection_classwrapper" class="anchor" href="#maerasection_classwrapper" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/section_class/wrapper</h3>

<p>Allows you to add classes to a wrapper div that includes the content area and the primary sidebar. Particularty useful if you're trying to achieve a template that has 3 columns and you need to float the content and sidebar to the right. Usage is exactly the same as the <a href="#maerasection_classprimary">maera/section_class/primary</a> action.</p>

<h3>
<a id="user-content-maerashellsavailable" class="anchor" href="#maerashellsavailable" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/shells/available</h3>

<p>You can use this filter to add your own shell in the list of available shells so that users can select and activate it.</p>

<p>Usage:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c"> * Include the shell</span></span>
<span class="pl-s2"><span class="pl-c"> */</span></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">maera_shell_core_include</span>( <span class="pl-vo">$shells</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-c">// Add our shell to the array of available shells</span></span>
<span class="pl-s2">    <span class="pl-vo">$shells</span>[] <span class="pl-k">=</span> <span class="pl-s3">array</span>(</span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>value<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>core<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>label<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>Core<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2">        <span class="pl-s1"><span class="pl-pds">'</span>class<span class="pl-pds">'</span></span> <span class="pl-k">=&gt;</span> <span class="pl-s1"><span class="pl-pds">'</span>Maera_Shell_Core<span class="pl-pds">'</span></span>,</span>
<span class="pl-s2">    );</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-vo">$shells</span>;</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/shells/available<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>maera_shell_core_include<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<p>More info can be found on the <a class="internal absent" href="/presscodes/maera/wiki/Defining-a-shell">Defining a shell</a> page.</p>

<h3>
<a id="user-content-maerastyles" class="anchor" href="#maerastyles" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/styles</h3>

<p>If you need to add some custom CSS to your page, you can use this filter.</p>

<p>Usage:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">custom_header_css</span>( <span class="pl-vo">$styles</span> ) {</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-vo">$image_url</span> <span class="pl-k">=</span> get_header_image();</span>
<span class="pl-s2">    <span class="pl-k">if</span> ( is_singular() <span class="pl-k">&amp;&amp;</span> has_post_thumbnail() ) {</span>
<span class="pl-s2">        <span class="pl-vo">$image_array</span> <span class="pl-k">=</span> wp_get_attachment_image_src( get_post_thumbnail_id(), <span class="pl-s1"><span class="pl-pds">'</span>full<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2">        <span class="pl-vo">$image_url</span> <span class="pl-k">=</span> <span class="pl-vo">$image_array</span>[<span class="pl-c1">0</span>];</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">    <span class="pl-k">if</span> ( <span class="pl-s3">empty</span>( <span class="pl-vo">$image_url</span> ) ) {</span>
<span class="pl-s2">        <span class="pl-k">return</span> <span class="pl-vo">$styles</span>;</span>
<span class="pl-s2">    } <span class="pl-k">else</span> {</span>
<span class="pl-s2">        <span class="pl-k">return</span> <span class="pl-vo">$styles</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>.page-header:before{ background: url("<span class="pl-pds">'</span></span> <span class="pl-k">.</span> <span class="pl-vo">$url</span> <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>") no-repeat center center; }<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2">    }</span>
<span class="pl-s2"></span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>maera/styles<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>custom_header_css<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2"></span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maerastylesheeturl" class="anchor" href="#maerastylesheeturl" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/stylesheet/url</h3>

<p>Changes the URL of the stylesheet to be loaded. You can use that if you're building your own shell to replace the default, empty stylesheet with your own.</p>

<p>Usage:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_stylesheet_url</span>() {</span>
<span class="pl-s2">    <span class="pl-k">return</span> get_stylesheet_directory_uri() <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>/assets/style.css<span class="pl-pds">'</span></span>;</span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/stylesheet/url<span class="pl-pds">'</span></span>, <span class="pl-s3">array</span>( <span class="pl-vo">$this</span>, <span class="pl-s1"><span class="pl-pds">'</span>my_stylesheet_url<span class="pl-pds">'</span></span> ) );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-maerastylesheetver" class="anchor" href="#maerastylesheetver" aria-hidden="true"><span class="octicon octicon-link"></span></a>maera/stylesheet/ver</h3>

<p>Changes the version of the stylesheet for cache custing.</p>

<p>Usage:</p>

<div class="highlight highlight-php"><pre><span class="pl-pse">&lt;?php</span><span class="pl-s2"></span>
<span class="pl-s2"></span>
<span class="pl-s2"><span class="pl-c">/**</span></span>
<span class="pl-s2"><span class="pl-c"> * Get the file modification time of our stylesheet</span></span>
<span class="pl-s2"><span class="pl-c"> * and use it as the file version.</span></span>
<span class="pl-s2"><span class="pl-c"> */</span></span>
<span class="pl-s2"><span class="pl-st">function</span> <span class="pl-en">my_stylesheet_version</span>() {</span>
<span class="pl-s2">    <span class="pl-k">return</span> <span class="pl-s3">filemtime</span>( get_stylesheet_directory() <span class="pl-k">.</span> <span class="pl-s1"><span class="pl-pds">'</span>/assets/style.css<span class="pl-pds">'</span></span> );</span>
<span class="pl-s2">}</span>
<span class="pl-s2">add_filter( <span class="pl-s1"><span class="pl-pds">'</span>maera/stylesheet/ver<span class="pl-pds">'</span></span>, <span class="pl-s3">array</span>( <span class="pl-vo">$this</span>, <span class="pl-s1"><span class="pl-pds">'</span>my_stylesheet_version<span class="pl-pds">'</span></span> ) );</span>
<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<h3>
<a id="user-content-other-filters-to-be-documented" class="anchor" href="#other-filters-to-be-documented" aria-hidden="true"><span class="octicon octicon-link"></span></a>Other filters (to be documented):</h3>

<ul class="task-list">
<li>maera/sidebar/footer</li>
<li>maera/sidebar/primary</li>
<li>maera/sidebar/secondary</li>
<li>maera/timber/locations</li>
<li>maera/title</li>
<li>maera/teaser/mode</li>
<li>maera/widgets/class</li>
<li>maera/widgets/title/after</li>
<li>maera/widgets/title/before</li>
<li>maera/plugins/required</li>
<li>maera/twig/placeholders</li>
<li>maera/templates</li>
<li>maera/template/plugin_compatibility</li>
<li>maera/timber/context</li>
<li>maera/timber/locations/roots</li>
<li>maera/timber/locations</li>
<li>maera/sidebar_template</li>
<li>maera/admin/tabs</li>
<li>maera/section_class/content</li>
</ul>

</div>

</div>
