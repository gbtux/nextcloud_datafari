<?php

style('datafari', array('style','uikit-datafari'));
?>

<div id="app" class="datafari">
	<div id="app-navigation" style="width: 350px;">
		<?php print_unescaped($this->inc('navigation/index')); ?>
		<?php //print_unescaped($this->inc('settings/index')); ?>
	</div>

	<div id="app-content"style="margin-left: 350px;">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('content/index', array('results' => $_['results']))); ?>
		</div>
	</div>
</div>

<?php
script('datafari', array('script','uikit.min','uikit-icons.min'));
?>