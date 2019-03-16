# WebberZone Code Library

This is a community-maintained repository of code snippets to help modify the default behaviour of the various plugins developed by [WebberZone](https://webberzone.com).

These are not add-on plugins as they would sit in their own repository.

Each plugin has a separate folder which contains its own set of sub-folders (categories). Each of these categories contain their set of snippets. Each snippet is placed in its own file with a name that describes what it does.

## Using snippets

Snippets have been either designed as WordPress plugins or as standalone functions. For snippets set up as WordPress plugins please follow the below instructions:

1. Click on the filename of the snippet you'd like to use. The ones set up as WordPress plugins have `* Plugin Name:` in the file comment
2. Click the "Raw" button (next to "Blame" and "History") at the top right
3. Save the page from your browser as a .php file in a folder of the same name
4. Compress the folder .zip file and upload this as a plugin in the *Plugins > Add New > Upload* plugin page.
5. Activate the plugin from the WordPress plugins page

For files that aren't set up as plugins (i.e. standalone functions), follow steps 1, 2  and 3 above and then copy and paste the code into your theme or child theme's *functions.php* or inside a custom functionality or Must Use plugin.

## Submitting Your Snippet

We welcome and encourage everyone to submit their code snippets. If you would like to submit your snippet, please [fork](https://github.com/WebberZone/code-library/fork) the repository and then create a [pull request](https://github.com/WebberZone/code-library/compare/).
You can also modify existing snippets in this way if you'd like to make them better.

Please refer to the [Contributing guidelines](https://github.com/WebberZone/code-library/blob/master/CONTRIBUTING.md) before submitting your pull request.

## Issues

These snippets come with no guarantees. As the code base of the plugins change, it might be possible that some snippets will be out-dated. Find something broken? [Let us know](https://github.com/WebberZone/code-library/issues)!
