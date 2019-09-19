<!-- Footer für die alle Seiten außer:

1. index.php
2. vertragsAuswahl
2. vertragsUebersicht

 -->
<footer>
	<div id="navbar-menu">
		<ul class="nav navbar-nav navbar-right">

		<!-- Button vertragsAuswahl-->				
			 <li class="btn-group dropup">
					<a href="../vertragsAuswahl.php" class="dropdown-toggle"><i class="glyphicon glyphicon-th"></i><span>VA</span><i class="icon-submenu lnr lnr-chevron-down"></i></a>
			 </li>
<!-- Button vertragsUebersicht-->				
			 <li class="btn-group dropup">
				<a href="../vertragsUebersicht.php" class="dropdown-toggle"><i class="glyphicon glyphicon-list-alt"></i><span>VUe</span><i class="icon-submenu lnr lnr-chevron-down"></i></a>
			 </li>
			 
<!-- Button Profil-->					
			 <li class="btn-group dropup">
				<a href="pDaten.php" class="dropdown-toggle"><i class="glyphicon glyphicon-user"></i><span>Profil</span><i class="icon-submenu lnr lnr-chevron-down"></i></a>
			 </li>
			 
<!-- Default dropup button (Bootstrap data-toggle="dropdown")für das DropUp Menü-->	
			 <li class="btn-group dropup">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i><span>Einstellungen</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
				<ul class="dropdown-menu">

<!-- Buttons für : Logout, FAQ, AGB, Datenschutz, Partner hinzufügen-->	
					<li><a href="vertragspartner.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Partner hinzufügen</span></a></li>
					<li><a href="datenschutz.php"><i class="glyphicon glyphicon-info-sign"></i> <span>Datenschutz</span></a></li>
					<li><a href="agb.php"><i class="glyphicon glyphicon-info-sign"></i> <span>AGB</span></a></li>
					<li><a href="faq.php"><i class="glyphicon glyphicon-info-sign"></i> <span>FAQ</span></a></li>
					<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
				</ul>
			</li>
		</ul>
	</div>
</footer>