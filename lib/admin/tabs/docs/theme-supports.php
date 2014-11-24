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
						<span class="pl-s2">    <span class="pl-c">// Add color calculations support</span></span>
						<span class="pl-s2">    <span class="pl-c">// Please note that this uses the 'jetpack_color' class.</span></span>
						<span class="pl-s2">    <span class="pl-c">// More info on that class here: https://github.com/Automattic/jetpack/blob/master/_inc/lib/class.color.php</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>maera_color<span class="pl-pds">'</span></span> );</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">    <span class="pl-c">// Add the tonesque library</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>tonesque<span class="pl-pds">'</span></span> );</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">    <span class="pl-c">// Add site-logo support</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>site-logo<span class="pl-pds">'</span></span> );</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">    <span class="pl-c">// Add breadcrumbs support</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>breadcrumbs<span class="pl-pds">'</span></span> );</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">    <span class="pl-c">// Add Less Compiler support</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>less_compiler<span class="pl-pds">'</span></span> )</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">    <span class="pl-c">// Add SASS/SCSS Compiler support</span></span>
						<span class="pl-s2">    add_theme_support( <span class="pl-s1"><span class="pl-pds">'</span>sass_compiler<span class="pl-pds">'</span></span> )</span>
						<span class="pl-s2"></span>
						<span class="pl-s2">}</span>
						<span class="pl-s2">add_action( <span class="pl-s1"><span class="pl-pds">'</span>after_setup_theme<span class="pl-pds">'</span></span>, <span class="pl-s1"><span class="pl-pds">'</span>my_theme_supports<span class="pl-pds">'</span></span> );</span>
						<span class="pl-s2"></span>
						<span class="pl-s2"></span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

						<p>You can find the list of theme_supports provided by Maera below:</p>

						<h2>
							<a id="user-content-color-calculations" class="anchor" href="#color-calculations" aria-hidden="true"><span class="octicon octicon-link"></span></a>Color calculations</h2>

							<p>If you need to do some color calculations performed, you can use Jetpack's color calculations class. If <a href="https://wordpress.org/plugins/jetpack/">Jetpack</a> is not installed, then we include this class on the theme core to reduce dependencies.<br>
								To include this feature you can use<br>
								<code>add_theme_support( 'maera_color' );</code></p>

								<h2>
									<a id="user-content-tonesque" class="anchor" href="#tonesque" aria-hidden="true"><span class="octicon octicon-link"></span></a>Tonesque</h2>

									<p>If you need to retrieve the main color of an image and perform calculations based on that color, you can use Jetpack's <a href="https://github.com/Automattic/jetpack/blob/master/_inc/lib/tonesque.php">Tonesque library</a>. If <a href="https://wordpress.org/plugins/jetpack/">Jetpack</a> is not installed, then we include this class on the theme core to reduce dependencies. Please note that when this is used, the color calculations class is also included.<br>
										To include this feature you can use<br>
										<code>add_theme_support( 'tonesque' );</code></p>

										<h2>
											<a id="user-content-site-logo" class="anchor" href="#site-logo" aria-hidden="true"><span class="octicon octicon-link"></span></a>Site Logo</h2>

											<p>Maera uses <a href="http://jetpack.me/support/site-logo/">JetPack's site-logo addon</a>. This way we're trying to standardize site logos usage across all shells.<br>
												To include this feature you can use<br>
												<code>add_theme_support( 'site-logo' );</code></p>

												<h2>
													<a id="user-content-breadcrumbs" class="anchor" href="#breadcrumbs" aria-hidden="true"><span class="octicon octicon-link"></span></a>Breadcrumbs</h2>

													<p>When you add support for breadcrumbs, the <a href="https://wordpress.org/plugins/breadcrumb-trail/">Breadcrumb-Trail</a> plugin is required to be downloaded. You can then use the plugin's arguments to configure it following the <a href="https://github.com/justintadlock/breadcrumb-trail#usage">instructions here</a>.<br>
														To include this feature you can use<br>
														<code>add_theme_support( 'breadcrumbs' );</code></p>

														<h2>
															<a id="user-content-compilers" class="anchor" href="#compilers" aria-hidden="true"><span class="octicon octicon-link"></span></a>Compilers</h2>

															<p>You can include .less and .scss compilers if your shells requires it. If you do, then the <a href="https://wordpress.org/plugins/lessphp/">Compilers plugin</a> will be required and downloaded on your site.
																To include this feature you can use<br>
																<code>add_theme_support( 'less-compiler' );</code><br>
																or<br>
																<code>add_theme_support( 'sass-compiler' );</code>  </p>

															</div>

															<div id="wiki-footer">
																<a href="/presscodes/maera/wiki/_new?wiki%5Bname%5D=_Footer" class="wiki-empty-box"><span class="octicon octicon-plus"></span> Add a custom footer</a>
															</div>
														</div>
