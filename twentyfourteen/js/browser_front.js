!function(){var t=function(t){return Array.prototype.slice.call(arguments,1).forEach(function(n){var e;for(e in n)n.hasOwnProperty(e)&&(t[e]=n[e])}),t},n=function(t,n){var e=n||document.documentElement;return e.querySelector(t)};Function.prototype.bind||(Function.prototype.bind=function(t){var n=[].slice.call(arguments,1),e=this,a=function(){},o=function(){return e.apply(this instanceof a?this:t||{},n.concat([].slice.call(arguments)))};return a.prototype=e.prototype,o.prototype=new a,o});var e,a,o=document.createElement("input");if("classList"in o)e=function(t,n){t.classList.add(n)},a=function(t,n){t.classList.remove(n)};else{var i=function(t){return new RegExp("(^|\\s+)"+t+"(\\s+|$)")};String.prototype.trim||(String.prototype.trim=function(t){return t.replace(/(^\s*|\s*$)/g,"")}),e=function(t,n){t.className=(t.className+" "+n).trim()},a=function(t,n){t.className=t.className.replace(i(n)," ").trim()}}var r=function(t){for(var n=document.cookie.split(";"),e=0;e<n.length;e++){var a=n[e].substr(0,n[e].indexOf("=")),o=n[e].substr(n[e].indexOf("=")+1);if(a=a.replace(/^\s+|\s+$/g,""),a==t)return decodeURIComponent(o)}return null},s=function(t,n,e){var a=new Date;a.setDate(a.getDate()+e),n=encodeURIComponent(n)+(null==e?"":"; expires="+a.toUTCString()),document.cookie=t+"="+n+"; path=/;"},c={ios:{appMeta:"ios-app",iconRels:["apple-touch-icon-precomposed","apple-touch-icon"],getStoreLink:function(){return"https://itunes.apple.com/"+this.options.appStoreLanguage+"/app/id"+this.appId},storeName:"iOS App Store"},android:{appMeta:"google-play-app",iconRels:["android-touch-icon","apple-touch-icon-precomposed","apple-touch-icon"],getStoreLink:function(){return"market://details?id="+this.appId},storeName:"Play Store"},amazon:{appMeta:"amazon-app",iconRels:["amazon-touch-icon","apple-touch-icon-precomposed","apple-touch-icon"],getStoreLink:function(){return"http://"+this.options[this.type].storeUrl+"/gp/product/"+this.appId+"/ref=mas_pm_"+this.options[this.type].appName},storeName:"Amazon Store"}},p=function(n){var e=navigator.userAgent;this.options=t({},{daysHidden:15,daysReminder:90,appStoreLanguage:"us",button:"VIEW",force:!1},n||{}),this.options.force?this.type=this.options.force:null!==e.match(/iPad|iPhone|iPod/i)?this.type="ios":null!==e.match(/Silk/i)?this.type="amazon":null!==e.match(/Android/i)&&(this.type="android"),!this.type||navigator.standalone||r("smartbanner-closed")||r("smartbanner-installed")||(t(this,c[this.type]),this.parseAppId()&&(this.create(),this.show()))};p.prototype={constructor:p,create:function(){for(var t,a=this.getStoreLink(),o=this.options[this.type].price+" - "+this.options[this.type].store,i=0;i<this.iconRels.length;i++){var r=n('link[rel="'+this.iconRels[i]+'"]');if(r){t=r.getAttribute("href");break}}var s=document.createElement("div");e(s,"smartbanner"),e(s,"smartbanner_"+this.type),s.innerHTML='<div class="smartbanner__container"><a href="javascript:void(0);" class="smartbanner__close">&times;</a><span class="smartbanner__icon" style="background-image: url('+t+')"></span><div class="smartbanner__info"><div class="smartbanner__title">'+this.options.title+"</div><div>"+this.options.author+"</div><span>"+o+'</span></div><a data-track-c="app links" data-track="click: smart banner '+this.storeName+'" data-track-l="smart banner '+this.storeName+'" data-track-click="smart banner '+this.storeName+'" href="'+a+'" class="smartbanner-button"><span class="smartbanner-button__text">'+this.options.button+"</span></a></div>",document.body.appendChild(s),n(".smartbanner-button",s).addEventListener("click",this.install.bind(this),!1),n(".smartbanner__close",s).addEventListener("click",this.close.bind(this),!1)},hide:function(){a(document.documentElement,"smartbanner_show")},show:function(){e(document.documentElement,"smartbanner_show")},close:function(){this.hide(),s("smartbanner-closed","true",this.options.daysHidden)},install:function(){this.hide(),s("smartbanner-installed","true",this.options.daysReminder)},parseAppId:function(){var t=n('meta[name="'+this.appMeta+'"]');if(t)return this.appId=/app-id=([^\s,]+)/.exec(t.getAttribute("content"))[1],this.appId}},window.SmartBanner=p}(),define("smart-app-banner",function(t){return function(){var n;return n||t.SmartBanner}}(this)),define("modules/smart-app-banner",["smart-app-banner","smart-app-banner.config"],function(t,n){if(n.content.show!==!1){new window.SmartBanner({daysHidden:21,daysReminder:14,appStoreLanguage:n.content.lang,title:n.content.labels.title,author:n.content.labels.author,button:n.content.labels.button,ios:{price:n.content.labels.iosPrice,store:n.content.labels.iosStore},android:{price:n.content.labels.androidPrice,store:n.content.labels.androidStore},amazon:{price:n.content.labels.amazonPrice,store:n.content.labels.amazonStore,appName:n.content.labels.amazonAppName,storeUrl:n.content.labels.amazonStoreUrl}})}}),require(["modules/smart-app-banner"]),define("browser_front",function(){});