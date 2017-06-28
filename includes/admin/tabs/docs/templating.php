<div id="wiki-body" class="gollum-markdown-content instapaper_body">
<div class="markdown-body">
<?php
printf(
    '<p>%s<a href="%s">%s</a>%s</p>',
    esc_html__( 'Maera is a WordPress theme and as such it follows the default WordPress ', 'maera' ),
    esc_url( 'http://wphierarchy.com/' ),
    esc_html__( 'template hierarchy', 'maera' ),
    esc_html__( ' However, we do have some extra stuff going on under the hood that we have found make life a lot easier both for skilled developers and for novice users that may not be php developers.', 'maera' )
);

?>

<?php
printf(
    "<p>%s<a href='%s'>%s</a>.\n<code>%s</code>%s</p>",
    esc_html__( 'In addition to the default template files that you can use if you want, we also provide a "views" folder that contains "twig" files. You can learn more about the twig language by clicking on ', 'maera' ),
    esc_url( 'http://twig.sensiolabs.org/' ),
    esc_html__( 'this link', 'maera' ),
    esc_html( 'twig' ),
    esc_html__( ' files have a structure and syntax a lot easier and more user-friendly than php. For example if you wanted to echo something in PHP, you would do this:', 'maera' )
);

?>

<div class="highlight highlight-php"><pre><span class="pl-s2"><span class="pl-k">&lt;</span>?<span class="pl-c1">php</span> <span class="pl-s3">echo</span> <span class="pl-vo">$foo</span>; </span><span class="pl-pse"><span class="pl-s2">?</span>&gt;</span></pre></div>

<?php
printf(
    "<p>%s</p>",
   esc_html__( 'In twig however it\'s a lot simpler than that:', 'maera' )
);
?>

<div class="highlight highlight-twig"><pre>{{ <span class="pl-vo">foo</span> }}</pre></div>

<?php
printf(
    "<p>%s <a href='%s'>%s</a>. </p>",
   esc_html__( 'You can learn more about the syntax and naming conventions by reading the', 'maera' ),
   esc_url( 'https://github.com/jarednova/timber/wiki' ),
   esc_html__( 'Timber docs', 'maera' )
);
?>

<p>To add your own templates you can create a <a>Child Theme</a> and either create custom php template files like you would do on every other WordPress theme, or custom twig templates.
The template hierarchy of the twig files is the same as the <a>default WordPress templates structure</a>, simply by replacing the <code>.php</code> suffix with <code>.twig</code>.
You can keep your <code>.twig</code> files in the root of your child theme, or a <code>/views</code> folder if you want to keep things a little more organized.</p>

<hr>

<h2>
<a id="user-content-template-hierarchy-on-the-maera-theme" class="anchor" href="#template-hierarchy-on-the-maera-theme" aria-hidden="true"><span class="octicon octicon-link"></span></a>Template hierarchy on the Maera theme:</h2>

<table>
<tbody><tr><th>
</th>
<td>Content Template</td>
<td>Sidebar Template</td>

</tr><tr>
<th>Author Archives</th>
<td>
author-{nicename}.twig, author-{ID}.twig, author.twig, archive.twig, index.twig
</td>
<td>
sidebar.twig
</td>
</tr>
<tr>
<th>Category Archives</th>
<td>
category-{slug}.twig, category-{ID}.twig, category.twig, archive.twig, index.twig
</td>
<td>
sidebar-category-{term_id}.twig, sidebar-category.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Custom Post Type Archives</th>
<td>
archive-{post_type}.twig, archive.twig, index.twig
</td>
<td>
sidebar-archive-{post_type}.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Custom Taxonomy Archives</th>
<td>
taxonomy-{term}.twig, taxonomy-{taxonomy}.twig, archive.twig, index.twig
</td>
<td>
sidebar-term-{term_id}.twig, sidebar-taxonomy-{taxonomy}.twig, sidebar-taxonomy.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Date Archives</th>
<td>
date.twig, archive.twig, index.twig
</td>
<td>
sidebar-date.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Tag Archives</th>
<td>
tag-{slug}.twig, tag-{ID}.twig, tag.twig, archive.twig, index.twig
</td>
<td>
sidebar-tag-{term_id}.twig, sidebar-tag.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Single Post</th>
<td>
single-post.twig, single.twig, index.twig
</td>
<td>
sidebar-{post-ID}.twig, sidebar-post.twig, sidebar-single.twig, sidebar.twig
</td>
</tr>
<tr>
<th>Single Page</th>
<td>
page-{slug}.twig, page-{ID}.twig, page.twig, index.twig
</td>
<td>
sidebar-{post-ID}.twig, sidebar-page.twig, sidebar-single.twig, sidebar.twig
</td>
</tr>
</tbody></table>

<?php
printf(
    '<h2><a id="user-content-the-stucture-of-a-rendered-page" class="anchor" href="#the-stucture-of-a-rendered-page" aria-hidden="true"><span class="octicon octicon-link"></span></a>%s</h2>',
   esc_html__( 'The stucture of a rendered page', 'maera' )
);
?>

<p>We divided the pages in sub-files in ordet to make them more modular.
You can see the twig file template parts on the below diagram:
<img src="https://camo.githubusercontent.com/160ce61f2a2250b16807698a3f093e9bf7d6158f/68747470733a2f2f70726573732e636f6465732f77702d636f6e74656e742f75706c6f6164732f74656d706c6174652d7374727563747572652e706e67" alt="Twig Template Parts" data-canonical-src="https://press.codes/wp-content/uploads/template-structure.png">
<a href="https://press.codes/wp-content/uploads/template-structure.png"><?php echo esc_html__( 'Get this file for a larger view', 'maera' ); ?> </a></p>

<h2>
<a id="user-content-post-properties-in-twig-files" class="anchor" href="#post-properties-in-twig-files" aria-hidden="true"><span class="octicon octicon-link"></span></a>Post properties in twig files</h2>

<pre><code>{{ post.ID }}                 // ID of the post
{{ post.post_author }}        // ID of the post author
{{ post.post_date }}          // timestamp in local time
{{ post.post_date_gmt }}      // timestamp in gmt time
{{ post.post_content }}       // Full (unprocessed) body of the post
{{ post.post_title }}         // title of the post
{{ post.post_excerpt }}       // excerpt field of the post, caption if attachment
{{ post.post_status }}        // post status: publish, new, pending, draft, auto-draft, future, private, inherit, trash
{{ post.comment_status }}     // comment status: open, closed
{{ post.ping_status }}        // ping/trackback status
{{ post.post_password }}      // password of the post
{{ post.post_name }}          // post slug, string to use in the URL
{{ post.post_modified }}      // timestamp in local time
{{ post.post_modified_gmt }}  // timestatmp in gmt time
{{ post.post_parent }}        // id of the parent post.
{{ post.guid }}               // global unique id of the post
{{ post.menu_order }}         // menu order
{{ post.post_type }}          // type of post: post, page, attachment, or custom string
{{ post.post_mime_type }}     // mime type for attachment posts
{{ post.comment_count }}      // number of comments
{{ post.terms }}              // taxonomy terms
{{ post.custom_field }}       // whatever custom field you've added (in the post_meta table)
</code></pre>

</div>

</div>
