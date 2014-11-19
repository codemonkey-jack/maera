<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <h1>
<a id="user-content-how-to-use-macros-in-your-templates" class="anchor" href="#how-to-use-macros-in-your-templates" aria-hidden="true"><span class="octicon octicon-link"></span></a>How to use macros in your templates</h1>

<p>There are many CSS frameworks out there like for example Bootstrap, Foundation, Pure and lots more. Each one of them defines a grid, buttons, alert messages and a lot of other things using its unique HTML structure, CSS class names etc.</p>

<p>We wanted to have a mechanism that will allow our plugins to be framework-agnostic, so if you write something in a plugin it can work no matter what shell/css-framework you use on your site.</p>

<p>To that end we are using <a href="http://twig.sensiolabs.org/doc/tags/macro.html">twig macros</a>.<br>
Macros are a way to standardize some common functionalities that most frameworks have (such as for example a grid or buttons) while at the same time allowing us to easily change these when creating a new shell.<br>
You can see a list of the default macros in <a href="https://github.com/presscodes/maera/tree/master/views/macros">the github repository</a>.<br>
For example the macro to create a new row in the core shell looks like this:</p>

<div class="highlight highlight-twig"><pre>{% <span class="pl-k">macro</span> row_open(<span class="pl-vo">element</span>, <span class="pl-vo">id</span>, <span class="pl-vo">extra_classes</span>, <span class="pl-vo">properties</span>) %}
    <span class="pl-ii">&lt;</span>{{ <span class="pl-vo">element</span><span class="pl-k">|</span><span class="pl-s3">default</span>(<span class="pl-s1"><span class="pl-pds">'</span>div<span class="pl-pds">'</span></span>) }} class="g{{ <span class="pl-vo">extra_classes</span> <span class="pl-k">?</span> <span class="pl-s1"><span class="pl-pds">'</span> <span class="pl-pds">'</span></span>~extra_classes <span class="pl-k">:</span> <span class="pl-s1"><span class="pl-pds">'</span><span class="pl-pds">'</span></span> }}"{{ <span class="pl-vo">id</span> <span class="pl-k">?</span> <span class="pl-s1"><span class="pl-pds">'</span> id="<span class="pl-pds">'</span></span>~id~<span class="pl-s1"><span class="pl-pds">'</span>"<span class="pl-pds">'</span></span> <span class="pl-k">:</span> <span class="pl-s1"><span class="pl-pds">'</span><span class="pl-pds">'</span></span> }}{{ <span class="pl-vo">properties</span> <span class="pl-k">?</span> <span class="pl-s1"><span class="pl-pds">'</span> <span class="pl-pds">'</span></span>~properties <span class="pl-k">:</span> <span class="pl-s1"><span class="pl-pds">'</span><span class="pl-pds">'</span></span> }}&gt;
{% <span class="pl-k">endmacro</span> %}</pre></div>

<p>If you want to use this macro in a twig custom twig file in your templates you will first have to import it by adding this line at the top of your twig file:</p>

<div class="highlight highlight-twig"><pre>{% <span class="pl-k">from</span> <span class="pl-s1"><span class="pl-pds">'</span>row_open.html.twig<span class="pl-pds">'</span></span> <span class="pl-k">import</span> <span class="pl-vo">row_open</span> <span class="pl-k">as</span> <span class="pl-vo">row_open</span> %}</pre></div>

<p>and then you can use it to open a row like this:</p>

<div class="highlight highlight-twig"><pre>{{ row_open( <span class="pl-s1"><span class="pl-pds">'</span>div<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>content<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>bg<span class="pl-pds">'</span></span> ) }}</pre></div>

<p>The above will have this as a result:</p>

<div class="highlight highlight-html"><pre>&lt;<span class="pl-ent">div</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>g bg<span class="pl-pds">"</span></span> <span class="pl-e">id</span>=<span class="pl-s1"><span class="pl-pds">"</span>content<span class="pl-pds">"</span></span>&gt;</pre></div>

<p>In addition, we also have shortcode-like syntax that can be entered wherever you want. The available functions that you can use this way are:</p>

<p><code>[maera_grid_container_open]</code> - opens a container div<br>
<code>[maera_grid_container_close]</code> - closes a container div<br>
<code>[maera_grid_row_open]</code> - open a row div<br>
<code>[maera_grid_row_close]</code> - closes a row div<br>
<code>[maera_grid_col_1]</code> - the column classes for width 1/12<br>
<code>[maera_grid_col_2]</code> - the column classes for width 2/12<br>
<code>[maera_grid_col_3]</code> - the column classes for width 3/12<br>
<code>[maera_grid_col_4]</code> - the column classes for width 4/12<br>
<code>[maera_grid_col_5]</code> - the column classes for width 5/12<br>
<code>[maera_grid_col_6]</code> - the column classes for width 6/12<br>
<code>[maera_grid_col_7]</code> - the column classes for width 7/12<br>
<code>[maera_grid_col_8]</code> - the column classes for width 8/12<br>
<code>[maera_grid_col_9]</code> - the column classes for width 9/12<br>
<code>[maera_grid_col_10]</code> - the column classes for width 10/12<br>
<code>[maera_grid_col_11]</code> - the column classes for width 11/12<br>
<code>[maera_grid_col_12]</code> - the column classes for width 12/12<br>
<code>[maera_button_default_extra_small]</code> - classes for default, extra-small buttons<br>
<code>[maera_button_default_small]</code> - classes for default, small buttons<br>
<code>[maera_button_default_medium]</code> - classes for default, medium buttons<br>
<code>[maera_button_default_large]</code> - classes for default, large buttons<br>
<code>[maera_button_default_extra_large]</code> - classes for default, extra-large buttons<br>
<code>[maera_button_primary_extra_small]</code> - classes for primary, extra-small buttons<br>
<code>[maera_button_primary_small]</code> - classes for primary, small buttons<br>
<code>[maera_button_primary_medium]</code> - classes for primary, medium buttons<br>
<code>[maera_button_primary_large]</code> - classes for primary, large buttons<br>
<code>[maera_button_primary_extra_large]</code> - classes for primary, extra-large buttons<br>
<code>[maera_button_success_extra_small]</code> - classes for success, extra-small buttons<br>
<code>[maera_button_success_small]</code> - classes for success, small buttons<br>
<code>[maera_button_success_medium]</code> - classes for success, medium buttons<br>
<code>[maera_button_success_large]</code> - classes for success, large buttons<br>
<code>[maera_button_success_extra_large]</code> - classes for success, extra-large buttons<br>
<code>[maera_button_info_extra_small]</code> - classes for info, extra-small buttons<br>
<code>[maera_button_info_small]</code> - classes for info, small buttons<br>
<code>[maera_button_info_medium]</code> - classes for info, medium buttons<br>
<code>[maera_button_info_large]</code> - classes for info, large buttons<br>
<code>[maera_button_info_extra_large]</code> - classes for info, extra-large buttons<br>
<code>[maera_button_warning_extra_small]</code> - classes for warning, extra small buttons<br>
<code>[maera_button_warning_small]</code> - classes for warning, small buttons<br>
<code>[maera_button_warning_medium]</code> - classes for warning, medium buttons<br>
<code>[maera_button_warning_large]</code> - classes for warning, large buttons<br>
<code>[maera_button_warning_extra_large]</code> - classes for warning, extra-large buttons<br>
<code>[maera_button_danger_extra_small]</code> - classes for danger, extra-small buttons<br>
<code>[maera_button_danger_small]</code> - classes for danger, small buttons<br>
<code>[maera_button_danger_medium]</code> - classes for danger, medium buttons<br>
<code>[maera_button_danger_large]</code> - classes for danger, large buttons<br>
<code>[maera_button_danger_extra_large]</code> - classes for danger, extra-large buttons<br>
<code>[maera_button_link_extra_small]</code> - classes for link, extra-small buttons<br>
<code>[maera_button_link_small]</code> - classes for link, small buttons<br>
<code>[maera_button_link_medium]</code> - classes for link, medium buttons<br>
<code>[maera_button_link_large]</code> - classes for link, large buttons<br>
<code>[maera_button_link_extra_large]</code> - classes for link, extra-large buttons  </p>

<p>Example scenario: A row that has a 3-column layout inside. The 1st column is half the width of the page, the 2nd column is a 3rd of the page width and the 3rd column is 1 6th of the page width. The 1st and 2nd columns also have a button in them:  </p>

<div class="highlight highlight-html"><pre>&lt;<span class="pl-ent">div</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_grid_row_open]<span class="pl-pds">"</span></span>&gt;
    &lt;<span class="pl-ent">div</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_grid_col_6]<span class="pl-pds">"</span></span>&gt;
        &lt;<span class="pl-ent">p</span>&gt;This column has a width of 6/12 (half the page/content)&lt;/<span class="pl-ent">p</span>&gt;
        &lt;<span class="pl-ent">a</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_button_success_small]<span class="pl-pds">"</span></span> <span class="pl-e">href</span>=<span class="pl-s1"><span class="pl-pds">"</span>#<span class="pl-pds">"</span></span>&gt;small green button&lt;/<span class="pl-ent">a</span>&gt;
    &lt;/<span class="pl-ent">div</span>&gt;
    &lt;<span class="pl-ent">div</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_grid_col_4]<span class="pl-pds">"</span></span>&gt;
        &lt;<span class="pl-ent">p</span>&gt;This column is 4/12 of the page/content (1 3rd of the width of its parent element)&lt;/<span class="pl-ent">p</span>&gt;
        &lt;<span class="pl-ent">a</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_button_danger_large]<span class="pl-pds">"</span></span> <span class="pl-e">href</span>=<span class="pl-s1"><span class="pl-pds">"</span>#<span class="pl-pds">"</span></span>&gt;large red button&lt;/<span class="pl-ent">a</span>&gt;
    &lt;/<span class="pl-ent">div</span>&gt;
    &lt;<span class="pl-ent">div</span> <span class="pl-e">class</span>=<span class="pl-s1"><span class="pl-pds">"</span>[maera_grid_col_2]<span class="pl-pds">"</span></span>&gt;
        &lt;<span class="pl-ent">p</span>&gt;This column is 2/12 of the page/content width. That's too narrow and rarely used&lt;/<span class="pl-ent">p</span>&gt;
    &lt;/<span class="pl-ent">div</span>&gt;
&lt;/<span class="pl-ent">div</span>&gt;</pre></div>

<p>Though the above example is pretty simplistic, it gives you an idea of how simple it is to implement these in your own templates. The great thing about them is that you can also use them <strong>in your content</strong>, so you can simply use them when using the WordPress content editor. This will allow you to have your content play nicely no matter which shell you're using. So you can be using <a href="http://getbootstrap.com/">Bootstrap</a> now and <a href="http://foundation.zurb.com/">foundation</a> next month, or even <a href="http://purecss.io/">purecss</a> and your content and customizations will look nice wherever you are.</p>

    </div>

    <div id="wiki-footer">
      <a href="/presscodes/maera/wiki/_new?wiki%5Bname%5D=_Footer" class="wiki-empty-box"><span class="octicon octicon-plus"></span> Add a custom footer</a>
    </div>
  </div>
