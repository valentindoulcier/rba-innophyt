<div id="deleteForm" style="display: none;">
	<div class="window" id="resultWindow">
		<ul>
			<li class="windowTitle"><h3><i class="icon-ok"></i>Suppression</h3></li>
			<li id="resultWindowContent">
				<div class="control-group">
					<div class="controls">
						<p class="lead" id="txt-delete-item"></p>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<div class="btn-toolbar">
							<div class="btn-group" style="margin-left: 150px;">
								<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Annuler</a>
								<a href="#" id="submit-form" class="btn btn-danger" onclick="deleteItem();">Supprimer</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div id="selectionner-item" style="display: none;">
	<div class="window" id="resultWindow">
		<ul>
			<li class="windowTitle"><h3><i class="icon-ok"></i>Attention</h3></li>
			<li id="resultWindowContent">
				<div class="control-group">
					<div class="controls">
						<p class="lead" id="txt-selectionner-item"></p>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<div class="btn-toolbar">
							<div class="btn-group" style="margin-left: 200px;">
								<a href="#" id="cancel-form" class="btn btn-info" onclick="Shadowbox.close();">Fermer</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div id="items-choisis" style="display: none;">
	<div class="window" id="resultWindow">
		<ul>
			<li class="windowTitle"><h3><i class="icon-ok"></i>Vous avez sélectionné</h3></li>
			<li id="resultWindowContent">
				<div class="form-horizontal formCampagne choose-info">
					<div class="control-group">
						<label class="control-label" for="dateFin">Campagne</label>
						<div id="choose-campagne" class="controls">
							<input id="choose-campagne-field" class="choose-campagne-field" name="choose-campagne-field" type="text" disabled>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="dateFin">Parcelle</label>
						<div id="choose-parcelle" class="controls">
							<input id="choose-parcelle-field" class="choose-parcelle-field" name="choose-parcelle-field" type="text" disabled>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="dateFin">Piège</label>
						<div id="choose-piege" class="controls">
							<input id="choose-piege-field" class="choose-piege-field" name="choose-piege-field" type="text" disabled>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<div class="btn-toolbar">
								<div class="btn-group">
									<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Fermer</a>
									<a href="<?php echo $QUIZZ_URL; ?>" id="cancel-form" class="btn btn-success" onclick="sessionStorage.removeItem(session_id_mosaique);">Identification</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>