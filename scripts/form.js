$(function(){$("select").each(function(){var e=$(this),t=$(this).children("option").length;e.addClass("select-hidden"),e.wrap('<div class="select"></div>'),e.after('<div class="select-styled"></div> ');var i=e.next("div.select-styled");i.text(e.children("option").eq(0).text());for(var l=$("<ul />",{"class":"select-options"}).insertAfter(i),s=0;t>s;s++)$("<li />",{text:e.children("option").eq(s).text(),rel:e.children("option").eq(s).val()}).appendTo(l);var c=l.children("li");i.click(function(e){e.stopPropagation(),$("div.select-styled.active").each(function(){$(this).removeClass("active").next("ul.select-options").hide()}),$(this).toggleClass("active").next("ul.select-options").toggle()}),c.click(function(t){t.stopPropagation(),i.text($(this).text()).removeClass("active"),e.val($(this).attr("rel")),l.hide()}),$(document).click(function(){i.removeClass("active"),l.hide()})})});