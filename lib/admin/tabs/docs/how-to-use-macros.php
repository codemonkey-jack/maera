<div id="wiki-body" class="gollum-markdown-content instapaper_body">
    <div class="markdown-body">
      <h1>
<a id="user-content-how-to-use-macros-in-your-templates" class="anchor" href="#how-to-use-macros-in-your-templates" aria-hidden="true"><span class="octicon octicon-link"></span></a>How to use macros in your templates</h1>

<p>There are many CSS frameworks out there like for example Bootstrap, Foundation, Pure and lots more. Each one of them defines a grid, buttons, alert messages and a lot of other things using its unique HTML structure, CSS class names etc.</p>

<p>We wanted to have a mechanism that will allow our plugins to be framework-agnostic, so if you write something in a plugin it can work no matter what shell/css-framework you use on your site.</p>

<p>Below you can find a list of the available macros and how to properly use them. If you're a developer and you want to write your own shell, please refer to the twig documentation and the stock shell.html.twig as an example.</p>

<hr>

<h2>
<a id="user-content-grid" class="anchor" href="#grid" aria-hidden="true"><span class="octicon octicon-link"></span></a>Grid</h2>

<h3>
<a id="user-content-open_container" class="anchor" href="#open_container" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_container</h3>

<p>Many frameworks require a container, so we're using this to open containers.</p>

<p>syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_container</span>(<span class="pl-v">element</span>, <span class="pl-v">id</span>, <span class="pl-v">extra_classes</span>, <span class="pl-v">properties</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>element</code>: can be any valid html element like <code>'div'</code>, <code>'section'</code> etc.<br>
</li>
<li>
<code>id</code>: the HTML ID that will be assigned to your container.<br>
</li>
<li>
<code>extra_classes</code>: any CSS classes that will be assigned to your element.<br>
</li>
<li>
<code>properties</code>: any extra markup that you want to add like for example schema.org definitions.</li>
</ul>

<h3>
<a id="user-content-close_container" class="anchor" href="#close_container" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_container</h3>

<p>Closes the container element that <code>open_container</code> opens.</p>

<p>syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">close_container</span>(<span class="pl-v">element</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>element</code>: can be any valid html element like <code>'div'</code>, <code>'section'</code> etc.<br>
</li>
</ul>

<h3>
<a id="user-content-open_row" class="anchor" href="#open_row" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_row</h3>

<p>similar to <a href="#open_container">open_container</a> but for rows instead of containers.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_row</span>(<span class="pl-v">element</span>, <span class="pl-v">id</span>, <span class="pl-v">extra_classes</span>, <span class="pl-v">properties</span>) }}</pre></div>

<h3>
<a id="user-content-close_row" class="anchor" href="#close_row" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_row</h3>

<p>similar to <a href="#close_container">close_container</a> but for rows instead of containers.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">close_row</span>(<span class="pl-v">element</span>) }}</pre></div>

<h3>
<a id="user-content-open_col" class="anchor" href="#open_col" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_col</h3>

<p>Creates columns defined by your CSS framework.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">open_col</span>(<span class="pl-v">element</span>, <span class="pl-v">sizes</span>, <span class="pl-v">id</span>, <span class="pl-v">extra_classes</span>, <span class="pl-v">properties</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>element</code>: can be any valid html element like <code>'div'</code>, <code>'section'</code> etc. </li>
<li>
<code>sizes</code> an array of sizes. example: <code>{mobile:12,tablet:6,medium:4,large:2}</code>. This will take care of breakpoints etc if the active shell is responsive using breakpoints. You could of course only define the medium size if you want using <code>{medium:6}</code>
</li>
<li>
<code>id</code>: the HTML ID that will be assigned to your container.<br>
</li>
<li>
<code>extra_classes</code>: any CSS classes that will be assigned to your element.<br>
</li>
<li>
<code>properties</code>: any extra markup that you want to add like for example schema.org definitions.</li>
</ul>

<h3>
<a id="user-content-close_col" class="anchor" href="#close_col" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_col</h3>

<p>similar to <a href="#close_container">close_container</a> but for rows instead of containers.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">close_col</span>(<span class="pl-v">element</span>) }}</pre></div>

<h3>
<a id="user-content-column_classes" class="anchor" href="#column_classes" aria-hidden="true"><span class="octicon octicon-link"></span></a>column_classes</h3>

<p>In case you don't want to use the automatic <a href="#open_col">open_col</a> macro and you simply want to get the grid classes for the sizes you define, you can use this macro.
It will return the css classes depending on the sizes you enter.<br>
It accepts an array and the syntax is identical to the <code>sizes</code> argument of the <a href="#open_col">open_col</a> macro.  </p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">column_classes</span>(<span class="pl-v">sizes</span>) }}</pre></div>

<hr>

<h2>
<a id="user-content-buttons" class="anchor" href="#buttons" aria-hidden="true"><span class="octicon octicon-link"></span></a>Buttons</h2>

<h3>
<a id="user-content-make_dropdown_button" class="anchor" href="#make_dropdown_button" aria-hidden="true"><span class="octicon octicon-link"></span></a>make_dropdown_button</h3>

<p>A lot of CSS frameworks include button dropdowns. This is how you can use them in your own twig files:</p>

<p>Syntax: </p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">make_dropdown_button</span>(<span class="pl-v">color</span>, <span class="pl-v">size</span>, <span class="pl-v">type</span>, <span class="pl-v">extra</span>, <span class="pl-v">label</span>, <span class="pl-v">content</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>color</code>: color can be one of these: <code>'default', 'primary', 'success', 'info', 'warning', 'danger'</code>. Default is traditionaly gray, primary is blue, success green, info teal, warning orange and danger red. These colors are of course not mandatory but these are the colors traditionally used to convey their nature.</li>
<li>
<code>size</code>: can be one of the following: <code>'extra-small', 'small', 'medium', 'large', 'extra-large'</code>.</li>
<li>
<code>type</code>: some css frameworks also have a type that you can use</li>
<li>
<code>extra</code>: any extra classes you want to assign to the button</li>
<li>
<code>label</code>: the label of the dropdown button</li>
<li>
<code>content</code>: the content of the actual dropdown.</li>
</ul>

<h3>
<a id="user-content-button_classes" class="anchor" href="#button_classes" aria-hidden="true"><span class="octicon octicon-link"></span></a>button_classes</h3>

<p>Returns the CSS classes for buttons.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">button_classes</span>(<span class="pl-v">color</span>, <span class="pl-v">size</span>, <span class="pl-v">type</span>, <span class="pl-v">extra</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>color</code>: color can be one of these: <code>'default', 'primary', 'success', 'info', 'warning', 'danger'</code>. Default is traditionaly gray, primary is blue, success green, info teal, warning orange and danger red. These colors are of course not mandatory but these are the colors traditionally used to convey their nature.</li>
<li>
<code>size</code>: can be one of the following: <code>'extra-small', 'small', 'medium', 'large', 'extra-large'</code>.</li>
<li>
<code>type</code>: some css frameworks also have a type that you can use</li>
<li>
<code>extra</code>: any extra classes you want to assign to the button</li>
</ul>

<h3>
<a id="user-content-button_group_classes" class="anchor" href="#button_group_classes" aria-hidden="true"><span class="octicon octicon-link"></span></a>button_group_classes</h3>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">button_group_classes</span>(<span class="pl-v">size</span>, <span class="pl-v">type</span>, <span class="pl-v">extra</span>) }}</pre></div>

<p>Arguments are the same as in the <a href="#button_classes">button_classes</a> macro.</p>

<hr>

<h2>
<a id="user-content-alerts" class="anchor" href="#alerts" aria-hidden="true"><span class="octicon octicon-link"></span></a>Alerts</h2>

<h3>
<a id="user-content-alert" class="anchor" href="#alert" aria-hidden="true"><span class="octicon octicon-link"></span></a>alert</h3>

<p>Creates an alert message on the page.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">alert</span>(<span class="pl-v">type</span>, <span class="pl-v">message</span>, <span class="pl-v">id</span>, <span class="pl-v">class</span>, <span class="pl-v">close</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>type</code>: type can be one of these: <code>'default', 'primary', 'success', 'info', 'warning', 'danger'</code>. Default is traditionaly slightly green, primary is blue, success green, info teal, warning orange and danger red. These colors are of course not mandatory but these are the colors traditionally used to convey their nature.</li>
<li>
<code>message</code>: the actual message that you want to print.</li>
<li>
<code>id</code> if you want to assign a CSS id to that alert message, you can do it here.</li>
<li>
<code>class</code>: any additional classes you want to assign to this error message</li>
<li>
<code>close</code>: if set to <code>true</code>, adds a xlose button to the alert message.</li>
</ul>

<hr>

<h2>
<a id="user-content-panels" class="anchor" href="#panels" aria-hidden="true"><span class="octicon octicon-link"></span></a>Panels</h2>

<h3>
<a id="user-content-open_panel" class="anchor" href="#open_panel" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_panel</h3>

<p>Creates a panel. Panels are simply wrapper divs for your content because sometimes you just want to have your content visually stand-out.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_panel</span>(<span class="pl-v">extra_classes</span>, <span class="pl-v">id</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>extra_classes</code>: adds any extra classes we may want.</li>
<li>
<code>id</code>: the id you want to assign to this panel.</li>
</ul>

<h3>
<a id="user-content-close_panel" class="anchor" href="#close_panel" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_panel</h3>

<p>Closes a panel that we opened.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>.<span class="pl-v">close_panel</span> }}</pre></div>

<h3>
<a id="user-content-open_panel_heading" class="anchor" href="#open_panel_heading" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_panel_heading</h3>

<p>Opens a heading for our panels.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_panel_heading</span>(<span class="pl-v">extra_classes</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>extra_classes</code>: adds any extra classes we may want.</li>
</ul>

<h3>
<a id="user-content-close_panel_heading" class="anchor" href="#close_panel_heading" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_panel_heading</h3>

<p>Closes an open panel heading.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>.<span class="pl-v">close_panel</span> }}</pre></div>

<h3>
<a id="user-content-open_panel_body" class="anchor" href="#open_panel_body" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_panel_body</h3>

<p>Opens a heading for our panels.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_panel_body</span>(<span class="pl-v">extra_classes</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>extra_classes</code>: adds any extra classes we may want.</li>
</ul>

<h3>
<a id="user-content-close_panel_body" class="anchor" href="#close_panel_body" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_panel_body</h3>

<p>Closes an open panel body.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>.<span class="pl-v">close_panel_body</span> }}</pre></div>

<h3>
<a id="user-content-open_panel_footer" class="anchor" href="#open_panel_footer" aria-hidden="true"><span class="octicon octicon-link"></span></a>open_panel_footer</h3>

<p>Opens a heading for our panels.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">open_panel_footer</span>(<span class="pl-v">extra_classes</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>extra_classes</code>: adds any extra classes we may want.</li>
</ul>

<h3>
<a id="user-content-close_panel_footer" class="anchor" href="#close_panel_footer" aria-hidden="true"><span class="octicon octicon-link"></span></a>close_panel_footer</h3>

<p>Closes an open panel body.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>.<span class="pl-v">close_panel_footer</span> }}</pre></div>

<hr>

<h2>
<a id="user-content-utilities" class="anchor" href="#utilities" aria-hidden="true"><span class="octicon octicon-link"></span></a>Utilities</h2>

<h3>
<a id="user-content-clearfix" class="anchor" href="#clearfix" aria-hidden="true"><span class="octicon octicon-link"></span></a>Clearfix</h3>

<p>Usually inserts a div that resets all floats and clearfixes your content.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>.<span class="pl-v">clearfix</span> }}</pre></div>

<h3>
<a id="user-content-pagination_ul_class" class="anchor" href="#pagination_ul_class" aria-hidden="true"><span class="octicon octicon-link"></span></a>pagination_ul_class</h3>

<p>Every CSS frameworks implements pagination differently. Usually all it takes is adding a different class to the pagination's <code>&lt;ul&gt;</code> element.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-v">shell</span>. <span class="pl-v">pagination_ul_class</span> }}</pre></div>

<h3>
<a id="user-content-float_class" class="anchor" href="#float_class" aria-hidden="true"><span class="octicon octicon-link"></span></a>float_class</h3>

<p>Most CSS frameworks have a mechanism for aligning content to the left or right.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">float_class</span>(<span class="pl-v">alignment</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>alignment</code>: can be <code>'left'</code> or <code>'right'</code>.</li>
</ul>

<h3>
<a id="user-content-icon" class="anchor" href="#icon" aria-hidden="true"><span class="octicon octicon-link"></span></a>icon</h3>

<p>The name of the icon you want to use (provided of course that the active shell uses an iconfont). Most iconfonts have the same names for their icons (excluding their iconfont-specific prefixes).
You can use common names like for example <code>'facebook'</code>. <code>'twitter'</code> and so on. The actual icon that will be used depends on the active shell and its implementation.</p>

<p>Syntax:</p>

<div class="highlight highlight-twig"><pre>{{ shell.<span class="pl-v">icon</span>(<span class="pl-v">symbol</span>) }}</pre></div>

<ul class="task-list">
<li>
<code>symbol</code>: the name of the icon you want to use.</li>
</ul>

    </div>
  </div>