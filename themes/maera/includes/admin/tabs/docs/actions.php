<div id="wiki-body" class="gollum-markdown-content instapaper_body">
<div class="markdown-body">
<h2>
<a id="user-content-available-actions" class="anchor" href="#available-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Available Actions:</h2>

<p>Below you can see a list of all the available actions in the Maera theme.</p>

<h1>
<a id="user-content-generic-actions" class="anchor" href="#generic-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Generic actions</h1>

<p><code>maera/admin/save</code></p>

<p>This action is run when the admin page is saved.
An example usage is when we import the customizer options in a shell that uses a compiler. In that case, when we perform the import we may want to trigger the shell's compiler so that the stylesheets get re-generated, caches dumped etc.</p>

<p><code>maera/shell/include_modules</code></p>

<p>This action is run when the shell is being initialized.</p>

<h1>
<a id="user-content-content-injecting-actions" class="anchor" href="#content-injecting-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Content-injecting actions</h1>

<ul class="task-list">
<li><code>maera/wrap/before</code></li>
<li><code>maera/wrap/after</code></li>
<li><code>maera/content/before</code></li>
<li><code>maera/content/after</code></li>
<li><code>maera/main/before</code></li>
<li><code>maera/main/after</code></li>
<li><code>maera/page/pre_content</code></li>
<li><code>maera/page/after_content</code></li>
<li><code>maera/entry/footer</code></li>
<li><code>maera/teaser/start</code></li>
<li><code>maera/single/top</code></li>
<li><code>maera/single/pre_content</code></li>
<li><code>maera/single/after_content</code></li>
<li><code>maera/in_article/top</code></li>
<li><code>maera/footer/before</code></li>
<li><code>maera/footer/start</code></li>
<li><code>maera/footer/content</code></li>
<li><code>maera/footer/end</code></li>
<li><code>maera/footer/after</code></li>
<li><code>maera/header/before</code></li>
<li><code>maera/header/after</code></li>
<li><code>maera/index/begin</code></li>
<li><code>maera/index/end</code></li>
<li><code>maera/in_loop/begin</code></li>
<li><code>maera/in_loop/end</code></li>
</ul>

</div>

</div>
