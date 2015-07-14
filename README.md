Maera
=====

![Maera Logo](http://press.codes/wp-content/uploads/maera-logo.png)

[![Code Climate](https://codeclimate.com/github/presscodes/maera/badges/gpa.svg)](https://codeclimate.com/github/presscodes/maera)

**Maera is a developer-friendly framework that allows you to quickly prototype sites and extend it with your own custom plugins.**

It is completely open-source, licensed under the MIT license
In its heart it uses the [twig templating engine](http://twig.sensiolabs.org/) and the WordPress Customizer.

With Maera we're introducing the concept of theme **shells**.  An easy way to completely customize the theme with your own markup, css, scripts and functionality to meet your own needs!

Maera is a WordPress theme and as such it follows the default WordPress [template hierarchy](http://wphierarchy.com/). However, we do have some extra stuff going on under the hood that we have found make life a lot easier both for skilled developers and for novice users that may not be php developers.

In addition to the default template files that you can use if you want, we also provide a "views" folder that contains "twig" files. You can learn more about the twig language by clicking on [this link](http://twig.sensiolabs.org/).
`twig` files have a structure and syntax a lot easier and more user-friendly than php. For example if you wanted to echo something in PHP, you would do this:

```php
<?php echo $foo; ?>
```

In twig however it's a lot simpler than that:

```twig
{{ foo }}
```

You can learn more about the syntax and naming conventions by reading the [Timber Docs](https://github.com/jarednova/timber/wiki).

To add your own templates you can create a [Child Theme](href="http://codex.wordpress.org/Child_Themes) and either create custom php template files like you would do on every other WordPress theme, or custom twig templates.
The template hierarchy of the twig files is the same as the [default WordPress templates structure](href="http://wphierarchy.com/), simply by replacing the `.php` suffix with `.twig`.
You can keep your `.twig` files in the root of your child theme, or a `/views` folder if you want to keep things a little more organized.

---

## Post properties in twig files

```
{{ post.ID }}                 // ID of the post
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
```
