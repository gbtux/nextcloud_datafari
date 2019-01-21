<div class="uk-container" style="padding-left: 15px;padding-right: 15px;margin-top: 30px;">
	<div class="uk-card uk-card-default uk-card-body ">
		<ul uk-accordion="multiple: true">
			<li class="uk-open">
				<a class="uk-accordion-title" href="#">Date</a>
				<div class="uk-accordion-content">
					<form>
    					<fieldset class="uk-fieldset" data-search="dates">
							<?php foreach($_['facets']['queries']['dates'] as $query => $nb){ ?>
							<div class="uk-margin">
								<label><input class="uk-checkbox" type="checkbox"> <?php p($query); ?> (<?php p($nb); ?>)</label>
							</div>
							<?php } ?>	
						</fieldset>
					</form>
				</div>
			</li>
			<li>
				<a class="uk-accordion-title" href="#">Type</a>
				<div class="uk-accordion-content">
					<form>
						<fieldset class="uk-fieldset" data-search="types">
							<?php foreach($_['facets']['fields']['extensions'] as $field => $nb){ ?>
								<div class="uk-margin">
									<label><input class="uk-checkbox" data-type="<?php p($field); ?>" type="checkbox"> <?php p($field); ?> (<?php p($nb); ?>)</label>
								</div>
							<?php } ?>
						</fieldset>
					</form>
				</div>
			</li>
			<li>
				<a class="uk-accordion-title" href="#">Source</a>
				<div class="uk-accordion-content">
					<form>
						<fieldset class="uk-fieldset" data-search="sources">
							<?php foreach($_['facets']['fields']['sources'] as $field => $nb){ ?>
								<div class="uk-margin">
									<label><input class="uk-checkbox" data-source="<?php p($field); ?>" type="checkbox"> <?php p($field); ?> (<?php p($nb); ?>)</label>
								</div>
							<?php } ?>
						</fieldset>
					</form>
				</div>
			</li>
			<li>
				<a class="uk-accordion-title" href="#">Langage</a>
				<div class="uk-accordion-content">
					<form>
						<fieldset class="uk-fieldset" data-search="languages">
							<?php foreach($_['facets']['fields']['languages'] as $field => $nb){ ?>
								<div class="uk-margin">
									<label><input class="uk-checkbox" data-language="<?php p($field); ?>" type="checkbox"> <?php p($field); ?> (<?php p($nb); ?>)</label>
								</div>
							<?php } ?>
						</fieldset>
					</form>
				</div>
			</li>
			<li>
				<a class="uk-accordion-title" href="#">Taille de fichier</a>
				<div class="uk-accordion-content">
					<form>
						<fieldset class="uk-fieldset" data-search="size">
							<?php foreach($_['facets']['queries']['size'] as $query => $nb){ ?>
								<div class="uk-margin">
									<label><input class="uk-checkbox" data-size="<?php p($query); ?>" type="checkbox"> <?php p($query); ?> (<?php p($nb); ?>)</label>
								</div>
							<?php } ?>
						</fieldset>
					</form>
				</div>
			</li>
		</ul>
	</div>
</div>