@extends('app')

@section('content')
<div class="page-title clearfix">
<ol class="breadcrumb">
<li class="active">Blank</li>
<li><a href="http://dashy.strapui.com/laravel"><i class="fa fa-tachometer"></i></a></li>
</ol>
</div>
<div class="conter-wrapper">
<div class="row">
<div class="col-md-6">
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Regular Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table ">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6a000502042a0d070b030644090507">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="97f1e5f6f9fcd7f0faf6fefbb9f4f8fa">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Bordered Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-bordered">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="fd97929593bd9a909c9491d39e9290">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="294f5b484742694e44484045074a4644">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="panel panel-info">
<div class="panel-heading">
<h3 class="panel-title">Striped Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-striped">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="d7bdb8bfb997b0bab6bebbf9b4b8ba">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="92f4e0f3fcf9d2f5fff3fbfebcf1fdff">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-success">
<div class="panel-heading">
<h3 class="panel-title">Hover Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-hover">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="8de7e2e5e3cdeae0ece4e1a3eee2e0">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="791f0b181712391e14181015571a1614">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="panel panel-danger">
<div class="panel-heading">
<h3 class="panel-title">Condensed Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-condensed">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="fa90959294ba9d979b9396d4999597">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="cbadb9aaa5a08baca6aaa2a7e5a8a4a6">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-warning">
<div class="panel-heading">
<h3 class="panel-title">Condensed, Bordered, Striped Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-condensed table-bordered table-striped">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr>
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6903060107290e04080005470a0604">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr>
<td>Andy</td>
<td>andygmail.com</td>
<td>Merseyside, UK</td>
</tr>
<tr>
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="f89e8a999693b89f95999194d69b9795">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
</tbody>
</table> </div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Coloured Table
<div class="panel-control pull-right hidden">
<a class="panelButton"><i class="fa fa-refresh"></i></a>
<a class="panelButton"><i class="fa fa-minus"></i></a>
<a class="panelButton"><i class="fa fa-remove"></i></a>
</div>
</h3>
</div>
<div class="panel-body">
<table class="table table-bordered white">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<tr class="success">
<td>John</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="650f0a0d0b250208040c094b060a08">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>London, UK</td>
</tr>
<tr class="info">
<td>Andy</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="f69798928fb6919b979f9ad895999b">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Merseyside, UK</td>
</tr>
<tr class="warning">
<td>Frank</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="d0b6a2b1bebb90b7bdb1b9bcfeb3bfbd">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Southampton, UK</td>
</tr>
<tr class="danger">
<td>Rickie</td>
<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6d1f040e0604082d0a000c0401430e0200">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
<td>Burnley, UK</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection
