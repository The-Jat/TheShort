/*
 * ====================================================================================
 * ----------------------------------------------------------------------------------
 *  This plugin is built for the Premium URL Shortener that can bought from 
 *  CodeCanyon. This will not work with any other URL shorteners and I will not 
 *  implement it to other scripts. This is distributed free of charge with the script.
 *
 *  Premium URL Shortener  - https://gempixel.com/buy/short
 *  Copyright (c) GemPixel - https://gempixel.com
 * ----------------------------------------------------------------------------------
 * ====================================================================================
 * 
 * Bookmarklet Widget
 * 
 * Widget drags into the toolbar and injects into to the page and shortens the current url.
 * 
 * version 2.0
 */
"use strict";
    
if(document.getElementById('gem-bookmarker')) document.getElementById('gem-bookmarker').remove();
    
document.body.innerHTML += '<div id="gem-bookmarker"><div id="gem-shadow" style="position: fixed;z-index: 9999;width: 100%;height: 100%;background: rgba(0,0,0,0.3);display: block;top: 0;left: 0;"></div> <div id="gem-widget" style="z-index:99999 !important;box-shadow:0 5px 20px rgba(0,0,0,0.2) !important;font-family:arial !important;font-size:13px !important;background:#fff !important;position:fixed !important;border-radius:5px !important;color:#000 !important; padding-bottom: 5px !important;"><h2 style="border-bottom:1px solid #eee !important;margin:0 !important ;padding:10px !important;font-size:14px !important;color:#000 !important;font-weight:900;">URL Shortener<a style="color:#000 !important;font-size:11px !important;text-align:right !important;text-decoration:none !important;float:right !important;margin-top:2px !important;" id="gem_bookmarklet_close" href="#close">(Close)</a></h2><form style="padding:10px !important;"><label for="gem-url">Short URL</label><input style="border-radius:3px !important;margin-top:10px !important;background:#fff !important;border:1px solid #000 !important;width:350px !important;display:block !important;padding:10px !important;color:#000;" type="text" name="url" id="gem-url" value="" readonly></form></div>';

document.getElementById('gem-widget').style.top = ((window.innerHeight - document.getElementById('gem-widget').clientHeight)/2) + 'px';
document.getElementById('gem-widget').style.left = ((window.innerWidth - document.getElementById('gem-widget').clientWidth)/2) + 'px';

document.getElementById('gem_bookmarklet_close').addEventListener('click', function(){
    document.getElementById('gem-bookmarker').remove();
    document.getElementById('gem_bookmarklet').remove();    
});

function gemProcess(response)
{
    if(typeof response !== 'object'){
        document.getElementById("gem-url").value = "Something went wrong somewhere. We are working on it.";
    }

    if(response.error == 1){
        document.getElementById("gem-url").value = response.msg;
    }else {
        document.getElementById("gem-url").value = response.short
        document.getElementById("gem-url").select();
    }
}

var script = document.createElement('script');
script.src = document.getElementById("gem_bookmarklet").getAttribute('data-url')+"/bookmark?token="+document.getElementById("gem_bookmarklet").getAttribute('data-token')+"&callback=gemProcess&url="+encodeURI(document.URL);

document.getElementsByTagName('head')[0].appendChild(script);