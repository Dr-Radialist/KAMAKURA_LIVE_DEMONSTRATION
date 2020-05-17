/**
 * jGlycy
 * (c) 2008 Semooh (http://semooh.jp/)
 * 
 */
!function($,prefix,jg){$[jg]=$({}),$[jg].extend({invoke:function(nodes){nodes.each(function(){var node=this,funcs=$(node).attr(prefix).split(",");$(funcs).each(function(){var arg=$(node).attr(prefix+":"+this);if(arg)eval("var options = {"+arg+"}");else var options={};$.fn[this]&&$(node)[this](options)})})},invokeElement:function(n){$[jg].invoke($("*["+prefix+"]",n))}}),$(document).ready(function(){$[jg].invokeElement(document)})}(jQuery,"jg","jg");