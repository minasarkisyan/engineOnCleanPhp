<!DOCTYPE html>
<html>
<?=$header?>
<body>
	<div id="container">
		<header>
			<h1>&lt;MyRusakov.ru /&gt;</h1>
			<?=$top?>
		</header>
		<div id="top">
			<div class="clear"></div>
			<div id="search">
				<form name="search" action="<?=$link_search?>" method="get">
					<table>
						<tr>
							<td>
								<input type="text" name="query" placeholder="Поиск" />
							</td>
							<td>
								<input type="submit" value="" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<?=$auth?>
		</div>
		<?=$slider?>
		<div id="content">
			<div id="left"><?=$left?></div>
			<div id="right"><?=$right?></div>
			<div id="center"><?=$center?></div>
			<div class="clear"></div>
		</div>
		<footer>
			<div class="sep"></div>
			<!-- Yandex.Metrika counter -->
			<div style="display:none;">
				<script type="text/javascript">
					(function(w, c) {
						(w[c] = w[c] || []).push(function() {
						   try {
							  w.yaCounter3932665 = new Ya.Metrika(3932665);
							   yaCounter3932665.clickmap(true);
							   yaCounter3932665.trackLinks(true);     
						   } catch(e) { }
					   });
					})(window, 'yandex_metrika_callbacks');
				</script>
			</div>
			<script src="/mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
			<noscript>
				<div style="position:absolute">
					<img src="/mc.yandex.ru/watch/3932665" alt="" />
				</div>
			</noscript>
			<!-- /Yandex.Metrika counter -->
			<!--LiveInternet counter-->
			<script type="text/javascript">
			<!--
				document.write("<a href='http://www.liveinternet.ru/click' "+
				"target=_blank><img src='//counter.yadro.ru/hit?t21.11;r"+
				escape(document.referrer)+((typeof(screen)=="undefined")?"":
				";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
				screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
				";"+Math.random()+
				"' alt='' title='LiveInternet: показано число просмотров за 24"+
				" часа, посетителей за 24 часа и за сегодня' "+
				"border='0' width='88' height='31'><\/a>")
			//-->
			</script>
			<!--/LiveInternet-->
			<!-- Rating@Mail.ru counter -->
			<script type="text/javascript">
				//<![CDATA[
				var a='';js=10;d=document;
				try{a+=';r='+escape(d.referrer);}catch(e){}try{a+=';j='+navigator.javaEnabled();js=11;}catch(e){}
				try{s=screen;a+=';s='+s.width+'*'+s.height;a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;}catch(e){}
				try{if(typeof((new Array).push('t'))==="number")js=13;}catch(e){}
				try{d.write('<a href="http://top.mail.ru/jump?from=1883459"><img src="http://dd.cb.bc.a1.top.mail.ru/counter?id=1883459;t=230;js='+js+
				a+';rand='+Math.random()+'" alt="Рейтинг@Mail.ru" style="border:0;" height="31" width="88" \/><\/a>');}catch(e){}
				//]]>
			</script>
			<noscript>
				<p>
					<a href="http://top.mail.ru/jump?from=1883459">
						<img src="http://dd.cb.bc.a1.top.mail.ru/counter?js=na;id=1883459;t=230" style="border: 0; height: 31px; width: 88px;"
						alt="Рейтинг@Mail.ru" />
					</a>
				</p>
			</noscript>
			<!-- //Rating@Mail.ru counter -->
			<!-- begin of Top100 code -->
			<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2243752"></script>
			<noscript>
				<p>
					<a href="http://top100.rambler.ru/navi/2243752/">
						<img src="http://counter.rambler.ru/top100.cnt?2243752" alt="Rambler's Top100" />
					</a>
				</p>
			</noscript>
			<!-- end of Top100 code -->
			<p>Copyright &copy; 2010-<?=date("Y")?> Русаков Михаил Юрьевич. Все права защищены.</p>
		</footer>
	</div>
</body>
</html>