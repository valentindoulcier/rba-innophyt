<div id="selectionner-aide" style="display: none;">
	<div class="window" id="resultWindow">
		<ul>
			<li class="windowTitle"><h3><i class="icon-ok"></i>Vous demandez de l'aide</h3></li>
			<li id="resultWindowContent">
				<div class="control-group">
					<div class="controls">
						<p class="lead">Choisissez votre action</p>
					</div>
				</div>
							
				<div class="control-group">
					<div class="controls">
						<div class="btn-toolbar">
							<div class="btn-group" style="margin-left: 150px; margin-top: 10px;">
								<a href="<?php echo $MAILTO; ?>" id="continue-form" class="btn btn-info" onclick="Shadowbox.close();">Envoyer un mail</a>
								<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Afficher PDF</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<footer id="footer" class="myContainer">
	<p class="left">
		<a href="<?php echo($PAGE_PATH)?>/apropos.php">A propos</a> | <a rel='shadowbox;width=450px;height=155px' href="#selectionner-aide">Aide</a> <!-- <a href="<?php echo $MAILTO; ?>">Aide</a> -->
	</p>
	<p class="right">
		Vous êtes déconnecté<i class="icon-remove-sign"></i>
	</p>
	<div class="clearer"></div>
</footer>
<input type="hidden" id="permalinkQuestionId" value=""/>

