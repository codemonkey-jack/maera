<div id="wiki-body" class="gollum-markdown-content instapaper_body">
  <div class="markdown-body">
      <h2>
          <a id="user-content-available-actions" class="anchor" href="#available-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Available Actions:
      </h2>

      <p>Below you can see a list of all the available actions in the Maera theme.</p>
      <p>You can use these to trigger some custom behavior, or to inject your own content wherever you need.</p>

      <h3>
          <a id="user-content-generic-actions" class="anchor" href="#generic-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Generic Actions
      </h3>

      <ul class="task-list">
          <li><code>maera/admin/save</code></li>
      </ul>
      <p>This action is run when the admin page is saved.</p>
      <p>An example usage is when we import the customizer options in a shell that uses a compiler. In that case, when we perform the import we may want to trigger the shell's compiler so that the stylesheets get re-generated, caches dumped etc.</p>

      <ul class="task-list">
          <li><code>maera/shell/include_modules</code></li>
      </ul>
      <p>We can use this action to make our own files and resources load when the shell is initialized.</p>

          <hr />
      <h3>
          <a id="user-content-content-related-actions" class="anchor" href="#content-related-actions" aria-hidden="true"><span class="octicon octicon-link"></span></a>Content-Related Actions
      </h3>
      <p>You can use the below actions to inject your content at any point in your theme using WordPress's <a href="http://codex.wordpress.org/Function_Reference/add_action">add_action</a> function.</p>

      <ul class="task-list">
          <li><code>maera/content/before</code></li>
          <li><code>maera/content/after</code></li>
          <li><code>maera/entry/meta</code></li>
          <li><code>maera/entry/footer</code></li>
          <li><code>maera/footer/before</code></li>
          <li><code>maera/footer/start</code></li>
          <li><code>maera/footer/content</code></li>
          <li><code>maera/footer/end</code></li>
          <li><code>maera/footer/after</code></li>
          <li><code>maera/header/before</code></li>
          <li><code>maera/header/after</code></li>
          <li><code>maera/in_article/top</code></li>
          <li><code>maera/in_loop/begin</code></li>
          <li><code>maera/in_loop/end</code></li>
          <li><code>maera/index/begin</code></li>
          <li><code>maera/index/end</code></li>
          <li><code>maera/main/before</code></li>
          <li><code>maera/main/after</code></li>
          <li><code>maera/page/after_content</code></li>
          <li><code>maera/page/pre_content</code></li>
          <li><code>maera/single/top</code></li>
          <li><code>maera/single/pre_content</code></li>
          <li><code>maera/single/after_content</code></li>
          <li><code>maera/teaser/start</code></li>
          <li><code>maera/wrap/before</code></li>
      </ul>
  </div>
</div>
