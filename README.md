# WebP Express

Serve autogenerated WebP images instead of jpeg/png to browsers that supports WebP. Works on anything (media library, galleries, theme images etc).

The plugin is available on the Wordpress codex ([here](https://wordpress.org/plugins/webp-express/)), and developed on github ([here](https://github.com/rosell-dk/webp-express/)).

## Description
Almost 4 out of 5 mobile users use a browser that is able to display webp images. Yet, on most websites, they are served jpeg images, which are typically double the size of webp images for a given quality. What a waste of bandwidth! This plugin was created to help remedy that situation. With little effort, Wordpress admins can have their site serving autogenerated webp images to browsers that supports it, while still serving jpeg and png files to browsers that does not support webp.

The plugin basically routes jpeg/png images to an image converter, or - if the image converter has already converted the image - directly to a converted image. The approach has the benefit that is works regardless of how an image found its way into your server - be it Media Library, Galleries, or even theme images referenced with CSS.

The plugin builds on [WebPConvert](https://github.com/rosell-dk/webp-convert) and its "WebP On Demand" solution described [here](https://github.com/rosell-dk/webp-convert/blob/master/docs/webp-on-demand/webp-on-demand.md)

#### Benefits
- Much faster load time for images in browsers that supports webp. The converted images are typically *less than half the size* (for jpeg), while maintaining the same quality. Bear in mind that for most web sites, images are responsible for the largest part of the waiting time.
- Better user experience (whether performance goes from terrible to bad, or from good to impressive, it is a benefit)
- Better ranking in Google searches (performance is taken into account by Google)
- Less bandwidth consumption - makes a huge difference in the parts of the world where the internet is slow and costly (you know, ~80% of the world population lives under these circumstances).
- Currently ~73% of all traffic, and ~78% of mobile browsing traffic are done with browsers supporting webp. With Mozilla and Microsoft [finally on board](https://medium.com/@richard_90141/webp-image-support-an-8-year-saga-7aa2bedb8d02), these numbers are bound to increase. Check current numbers on  [caniuse.com](https://caniuse.com/webp)).


## Installation

1. Upload the plugin files to the `/wp-content/plugins/webp-express` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure it (the plugin doesn't do anything until configured)
4. Verify that it works

### Configuring
You configure the plugin in *Settings > WebP Express*.

#### Conversion methods
WebP Express has a bunch of methods available for converting images: Executing cwebp binary, Gd extension, Imagick extension, ewww cloud converter and remote WebP express. Each requires *something*. In many cases, one of the conversion methods will be available. You can quickly identify which converters are working - there is a green icon next to them. Hovering conversion methods that are not working will show you what is wrong.

In case no conversion methods are working out of the box, you have several options:
- You can install this plugin on another website, which supports a local conversion method and connect to that using the "Remote WebP Express" conversion method
- You can [purchase a key](https://ewww.io/plans/) for the ewww cloud converter. They do not charge credits for webp conversions, so all you ever have to pay is the one dollar start-up fee :)
- You can set up [webp-convert-cloud-service](https://github.com/rosell-dk/webp-convert-cloud-service) on another server and connect to that. Its open source.
- You can try to meet the server requirements of cwebp, gd, imagick or gmagick. Check out [this wiki page](https://github.com/rosell-dk/webp-convert/wiki/Meeting-the-requirements-of-the-converters) on how to do that

### The auto quality
If your server has imagick og gmagick installed, the plugin will be able to detect the quality of a jpeg, and use the same quality for the converted webp. You can tell if it does, by looking at the quality option. If it allows you to select "auto" quality, it is available, otherwise it is not, and you will only have the option to set a specific quality for all conversions. *Auto* should be chosen, if available, as this ensures that each conversion are converted with an appropriate quality. Say you have a jpeg with low quality (say 30). The best result, is achieved by converting it to the same quality. Converting it with high quality (say 80), will not get you better quality, only a larger file.

If you do not the "auto" option available:
- Install imagick or gmagick, if you can
- Use "Remote WebP Express" converter to connect to a site, that *does* have the auto option available
- If you have cwebp converter available, you can configure it to aim for a certain reduction, rather than using the quality parameter. Set this to for example 50%, or even 45%.

### Verifying that it works.
Once, you have a converter, that works, when you click the "test"-button, you are ready to test the whole stack, and the rewrite rules. To do this, first make sure to select something other than "Do not convert any images!" in *Image types to convert*. Next, click "Save settings". This will save settings, as well as update the *.htaccess*.

If you are working in a browser that supports webp (ie Google Chrome), you will see a link "Convert test image (show debug)" after a successful save. Click that to test if it works. The screen should show a textual report of the conversion process. If it shows an image, it means that the *.htaccess* redirection isn't working. It may be that your server just needs some time. Some servers has set up caching. It could also be that your images are handled by nginx.

Note that the plugin does not change any HTML. In the HTML the image src is still set to ie "example.jpg". To verify that the plugin is working (without clicking the test button), do the following:

- Open the page in Google Chrome
- Right-click the page and choose "Inspect"
- Click the "Network" tab
- Reload the page
- Find a jpeg or png image in the list. In the "type" column, it should say "webp"

In order to test that the image is not being reconverted every time, look at the Response headers of the image. There should be a "X-WebP-Convert-Status" header. It should say "Serving existing converted image" the first time, but "Serving existing converted image" on subsequent requests (WebP-Express is based upon [WebP Convert](https://github.com/rosell-dk/webp-convert)).

You can also append `?debug` after any image url, in order to run a conversion, and see the conversion report. Also, if you append `?reconvert` after an image url, you will force a reconversion of the image.

### Notes

*Note:*
The redirect rules created in *.htaccess* are pointing to a PHP script. If you happen to change the url path of your plugins, the rules will have to be updated. The *.htaccess* also passes the path to wp-content (relative to document root) to the script, so the script knows where to find its configuration and where to store converted images. So again, if you move the wp-content folder, or perhaps moves Wordpress to a subfolder, the rules will have to be updated. As moving these things around is is a rare situation, WebP Express are not using any resources monitoring this. However, it will do the check when you visit the settings page.

*Note:*
Do not simply remove the plugin without deactivating it first. Deactivation takes care of removing the rules in the *.htaccess* file. With the rules there, but converter gone, your Google Chrome visitors will not see any jpeg images.

*Note:*
The plugin has not been tested in multisite configurations.


## Limitations

* The plugin does not work on Microsoft IIS server, nor in WAMP
* The plugin has not been tested with multisite installation

## Frequently Asked Questions

### How do I verify that the plugin is working?
See the "Verifying that it works section"

### No conversions methods are working out of the box
Don't fret - you have options!

- If you a controlling another WordPress site (where the local conversion methods DO work), you can set up WebP Express there, and then connect to it by configuring the “Remote WebP Express” conversion method.
- You can also setup the ewww conversion method. To use it, you need to purchase an api key. They do not charge credits for webp conversions, so all you ever have to pay is the one dollar start-up fee 🙂 (unless they change their pricing – I have no control over that). You can buy an api key here: https://ewww.io/plans/
- If you are up to it, you can try to get one of the local converters working. Check out [this page](https://github.com/rosell-dk/webp-convert/wiki/Meeting-the-requirements-of-the-converters) on the webp-convert wiki
- Finally, if you have access to a server and are comfortable with installing projects with composer, you can install [webp-convert-cloud-service](https://github.com/rosell-dk/webp-convert-cloud-service). It's open source.

### It doesn't work - Although test conversions work, it still serves jpeg images.
Actually, you might be mistaking, so first, make sure that you didn't make the very common mistake of thinking that something with the URL *example.com/image.jpg* must be a jpeg image. The plugin serves webp images on same URL as the original (unconverted) images, so do not let appearances fool you! Confused? See next FAQ item.

Assuming that you have inspected the *content type* header, and it doesn't show "image/webp", please make sure that:
1) You tested with a browser that supports webp (such as Chrome)
2) The image URL you are looking at are not pointing to another server (such as gravatar.com)

Assuming that all above is in place, please look at the response headers to see if there is a *X-WebP-Convert-Status* header. If there isn't, well, then it seems that the problem is that the image request isn't handed over to WebP Express. Reasons for that can be:

- You are on NGINX (or an Apache/Nginx combination). NGINX requires special attention, please look at that FAQ item
- You are on WAMP. Please look at that FAQ item

I shall write more on this FAQ item... Stay tuned.

### How can a webp image be served on an URL ending with "jpg"?
Easy enough. Browsers looks at the *content type* header rather than the URL to determine what it is that it gets. So, although it can be confusing that the resource at *example.com/image.jpg* is a webp image, rest asure that the browsers are not confused. To determine if the plugin is working, you must therefore examine the *content type* response header rather than the URL. See the "How do I verify that the plugin is working?" Faq item.

I am btw considering making an option to have the plugin redirect to the webp instead of serving immediately. That would remove the apparent mismatch between file extension and content type header. However, the cost of doing that will be an extra request for each image, which means extra time and worse performance. I believe you'd be ill advised to use that option, so I guess I will not implement it. But perhaps you have good reasons to use it? If you do, please let me know!

### I am on NGINX / OpenResty
It is possible to make WebP Express work on NGINX, but it requieres manually inserting redirection rules in the NGINX configuration file (nginx.conf). For standard wordpress installations, the following rules should work:

```
if ($http_accept ~* “webp”){
rewrite ^/(.*).(jpe?g|png)$ /wp-content/plugins/webp-express/wod/webp-on-demand.php?source=$document_root$request_uri&wp-content=wp-content&%1 break;
}
```
However, the location of the wp-content folder and the plugins folder can be customized with Wordpress. In that case, the above rule must be changed accordingly.

I'd like to make the plugin print the NGINX rules that needs to be inserted, when running on NGINX / NGINX based setup (ie [OpenResty](https://openresty.org/en/)). Please help make that possible by [contributing](https://www.patreon.com/rosell).

Discussion on this topic here: https://wordpress.org/support/topic/nginx-rewrite-rules-4/

### I am on a WAMP stack
It has been reported that WebP Express *almost* works on WAMP stack (Windows, Apache, MySQL, PHP). I'd love to debug this, but do not own a Windows server or access to one... Can you help?

### Why do I not see the option to set WebP quality to auto?
The option will only display, if your system is able to detect jpeg qualities. To make your server capable to do that, install *Imagick* or *Gmagick*

### How do I make this work with a CDN?
Chances are that the default setting of your CDN is not to forward any headers to your origin server. But the plugin needs the "Accept" header, because this is where the information is whether the browser accepts webp images or not. You will therefore have to make sure to configure your CDN to forward the "Accept" header.

The plugin takes care of setting the "Vary" HTTP header to "Accept" when routing WebP images. When the CDN sees this, it knows that the response varies, depending on the "Accept" header. The CDN is thus instructed not to cache the response on URL only, but also on the "Accept" header. This means that it will store an image for every accept header it meets. Luckily, there are (not that many variants for images)[https://developer.mozilla.org/en-US/docs/Web/HTTP/Content_negotiation/List_of_default_Accept_values#Values_for_an_image], so it is not an issue.

## Changes in 0.8.0
- New conversion method, which calls imagick binary directly. This will make WebP express work out of the box on more systems
- Made sure not to trigger LFI warning i Wordfence (to activate, click the force .htaccess button)
- Imagick can now be configured to set quality to auto (but only when the "auto" option isn't generally available)
- Added Last-Modified header to images. This makes image caching work better
- On some systems, converted files where stored in ie *..doc-rootwp-content..* rather than *..doc-root/wp-content..*. This is fixed, a clean-up script corrects the file structure upon upgrade.

For more info, see the closed issues on the 0.8.0 milestone on the github repository: https://github.com/rosell-dk/webp-express/issues?q=is%3Aclosed+milestone%3A0.8.0

## Supporting WebP Express
Bread on the table don't come for free, even though this plugin does, and always will. I enjoy developing this, and supporting you guys, but I kind of need the bread too. Please make it possible for me to continue putting effort into this plugin:

- [Buy me a Coffee](https://ko-fi.com/rosell)
- [Become a backer or sponsor on Patreon](https://www.patreon.com/rosell).
