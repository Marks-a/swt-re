<header>
    <nav class="header-buttons">
        <?php foreach ($buttons as $button): ?>
            <?php if ($button->getType() === 'submit'): ?>
                <button 
                    type="button" 
                    id="<?= $button->getId(); ?>"
                    data-role="submit-form"
                    class="button"
                >
                    <?= $button->getText(); ?>
                </button>
            <?php else: ?>
                <a href="<?= htmlspecialchars($button->getLink()) ?>" 
                   id="<?= $button->getId() ?>" 
                   class="button">
                    <?= $button->getText() ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
</header>
