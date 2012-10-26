url-find-and-replace-wordpress
==============================

Find a string in the current URL, replace it, and redirect to the new URL. The redirect used is a "301 moved permanently".

Configure your find and replace strings in **Settings -> Permalinks** in the WordPress admin panel.

No, it doesn't support using a regex. If you're smart enough to know how to write a regex, I suspect you can fork the plugin and replace the following line of code yourself:

```
$redirect_url = str_replace($old, $new, $current_url);
```

**Example**
- Let's say, for instance, that you own two domains: myawesomedomain.com and mysweetdomain.com.
- Your WordPress site is currently being shown on myawesomedomain.com
- You want your WordPress site to show on mysweetdomain.com
- Install this plugin and configure your **find** string to be "myawesomedomain.com" and your **replace** string to be "mysweetdomain.com".
- **Note that you must configure your hosting environment such that both myawesomedomain.com and mysweetdomain.com point to the same web root, or at least exact duplicate copies.**

I realize that the actual usefulness of this plugin is quite limited. I also realize that the same effect (or better) could be achieved via .htaccess files.

**Use with caution.** If you do break your website with this plugin, just delete it via FTP.