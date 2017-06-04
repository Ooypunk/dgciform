<div class="form-group">
	<label for="<?= $this->getId() ?>"><?= $this->getLabel() ?></label>
	<select name="<?= $this->getName() ?>" class="form-control <?= $this->getClass() ?>">
		<?php
		foreach ($this->getOptions() as $option_value => $option_label) {
			$selected = $this->isSelected($option_value) ? ' selected="selected"' : '';
			print '<option value="' . $option_value . '"' . $selected . '>' . $option_label . '</option>' . PHP_EOL;
		}
		?>
	</select>
</div>
